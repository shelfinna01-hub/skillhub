<?php

use App\Models\User;
use App\Models\Kelas;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    // Create test admin and peserta users
    /** @var User */
    $this->admin = User::create([
        'name' => 'Admin Test',
        'email' => 'admin@test.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);

    /** @var User */
    $this->peserta = User::create([
        'name' => 'Peserta Test',
        'email' => 'peserta@test.com',
        'password' => Hash::make('password'),
        'role' => 'peserta',
    ]);
});

test('admin can access admin dashboard', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.dashboard'));

    $response->assertOk();
    $response->assertViewIs('admin.dashboard');
});

test('peserta can access peserta dashboard', function () {
    $response = $this->actingAs($this->peserta)
        ->get(route('peserta.dashboard'));

    $response->assertOk();
    $response->assertViewIs('peserta.dashboard');
});

test('peserta dashboard shows registered classes', function () {
    $kelas = Kelas::create([
        'name' => 'Test Kelas',
        'description' => 'Test Description',
        'instructor' => 'Test Instructor',
    ]);

    Pendaftaran::create([
        'user_id' => $this->peserta->id,
        'kelas_id' => $kelas->id,
    ]);

    $response = $this->actingAs($this->peserta)
        ->get(route('peserta.dashboard'));

    $response->assertOk();
    $response->assertViewHas('pendaftaran');
    $this->assertCount(1, $response->viewData('pendaftaran'));
});

test('admin can view users index page', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.peserta.index'));

    $response->assertOk();
    $response->assertViewIs('admin.peserta.index');
    $response->assertViewHas(['admins', 'pesertas']);
});

test('peserta cannot access admin routes', function () {
    $response = $this->actingAs($this->peserta)
        ->get(route('admin.peserta.index'));

    $response->assertStatus(403);
});

test('admin can view create user form', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.peserta.create'));

    $response->assertOk();
    $response->assertViewIs('admin.peserta.create');
});

test('admin can create new peserta user', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.peserta.store'), [
            'name' => 'New Peserta',
            'email' => 'newpeserta@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'peserta',
        ]);

    $response->assertRedirect(route('admin.peserta.index'));
    $response->assertSessionHas('success');
    
    $this->assertDatabaseHas('users', [
        'name' => 'New Peserta',
        'email' => 'newpeserta@test.com',
        'role' => 'peserta',
    ]);
});

test('admin can create new admin user', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.peserta.store'), [
            'name' => 'New Admin',
            'email' => 'newadmin@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ]);

    $response->assertRedirect(route('admin.peserta.index'));
    $response->assertSessionHas('success');
    
    $this->assertDatabaseHas('users', [
        'name' => 'New Admin',
        'email' => 'newadmin@test.com',
        'role' => 'admin',
    ]);
});

test('store user validates required fields', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.peserta.store'), []);

    $response->assertSessionHasErrors(['name', 'email', 'password', 'role']);
});

test('store user validates email uniqueness', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.peserta.store'), [
            'name' => 'Duplicate Email',
            'email' => $this->peserta->email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'peserta',
        ]);

    $response->assertSessionHasErrors(['email']);
});

test('store user validates password confirmation', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.peserta.store'), [
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => 'password123',
            'password_confirmation' => 'differentpassword',
            'role' => 'peserta',
        ]);

    $response->assertSessionHasErrors(['password']);
});

test('admin can view user details', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.peserta.show', $this->peserta));

    $response->assertOk();
    $response->assertViewIs('admin.peserta.show');
    $response->assertViewHas('peserta', $this->peserta);
});

test('admin can view edit user form', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.peserta.edit', $this->peserta));

    $response->assertOk();
    $response->assertViewIs('admin.peserta.edit');
    $response->assertViewHas('peserta', $this->peserta);
});

test('admin can update user', function () {
    $response = $this->actingAs($this->admin)
        ->put(route('admin.peserta.update', $this->peserta), [
            'name' => 'Updated Name',
            'email' => 'updated@test.com',
            'role' => 'peserta',
        ]);

    $response->assertRedirect(route('admin.peserta.index'));
    $response->assertSessionHas('success');
    
    $this->assertDatabaseHas('users', [
        'id' => $this->peserta->id,
        'name' => 'Updated Name',
        'email' => 'updated@test.com',
    ]);
});

test('admin can update user with new password', function () {
    $response = $this->actingAs($this->admin)
        ->put(route('admin.peserta.update', $this->peserta), [
            'name' => $this->peserta->name,
            'email' => $this->peserta->email,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
            'role' => 'peserta',
        ]);

    $response->assertRedirect(route('admin.peserta.index'));
    
    $this->peserta->refresh();
    $this->assertTrue(Hash::check('newpassword123', $this->peserta->password));
});

test('admin can update user without password', function () {
    $oldPassword = $this->peserta->password;
    
    $response = $this->actingAs($this->admin)
        ->put(route('admin.peserta.update', $this->peserta), [
            'name' => 'Updated Without Password',
            'email' => $this->peserta->email,
            'role' => 'peserta',
        ]);

    $response->assertRedirect(route('admin.peserta.index'));
    
    $this->peserta->refresh();
    $this->assertEquals($oldPassword, $this->peserta->password);
});

test('admin cannot delete own account', function () {
    $response = $this->actingAs($this->admin)
        ->delete(route('admin.peserta.destroy', $this->admin));

    $response->assertRedirect(route('admin.peserta.index'));
    $response->assertSessionHas('error');
    
    $this->assertDatabaseHas('users', [
        'id' => $this->admin->id,
    ]);
});

test('admin can delete other user', function () {
    $response = $this->actingAs($this->admin)
        ->delete(route('admin.peserta.destroy', $this->peserta));

    $response->assertRedirect(route('admin.peserta.index'));
    $response->assertSessionHas('success');
    
    $this->assertDatabaseMissing('users', [
        'id' => $this->peserta->id,
    ]);
});

test('update validates email uniqueness excluding current user', function () {
    $anotherUser = User::create([
        'name' => 'Another User',
        'email' => 'another@test.com',
        'password' => Hash::make('password'),
        'role' => 'peserta',
    ]);

    $response = $this->actingAs($this->admin)
        ->put(route('admin.peserta.update', $this->peserta), [
            'name' => 'Test User',
            'email' => $anotherUser->email,
            'role' => 'peserta',
        ]);

    $response->assertSessionHasErrors(['email']);
});

test('unauthorized user cannot access user management', function () {
    $response = $this->get(route('admin.peserta.index'));

    $response->assertRedirect(route('login'));
});

