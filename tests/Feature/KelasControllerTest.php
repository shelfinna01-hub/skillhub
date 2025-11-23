<?php

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;

/**
 * @var User $admin
 * @var User $peserta
 */
beforeEach(function () {
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

test('admin can view kelas index page', function () {
    Kelas::create([
        'name' => 'Test Kelas 1',
        'description' => 'Description 1',
        'instructor' => 'Instructor 1',
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.kelas.index'));

    $response->assertOk();
    $response->assertViewIs('admin.kelas.index');
    $response->assertViewHas('kelas');
});

test('peserta cannot access kelas management', function () {
    $response = $this->actingAs($this->peserta)
        ->get(route('admin.kelas.index'));

    $response->assertStatus(403);
});

test('admin can view create kelas form', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.kelas.create'));

    $response->assertOk();
    $response->assertViewIs('admin.kelas.create');
});

test('admin can create new kelas', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.kelas.store'), [
            'name' => 'New Kelas',
            'description' => 'New Description',
            'instructor' => 'New Instructor',
        ]);

    $response->assertRedirect(route('admin.kelas.index'));
    $response->assertSessionHas('success');
    
    $this->assertDatabaseHas('kelas', [
        'name' => 'New Kelas',
        'description' => 'New Description',
        'instructor' => 'New Instructor',
    ]);
});

test('store kelas validates required fields', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.kelas.store'), []);

    $response->assertSessionHasErrors(['name', 'description', 'instructor']);
});

test('admin can view kelas details', function () {
    $kelas = Kelas::create([
        'name' => 'Test Kelas',
        'description' => 'Test Description',
        'instructor' => 'Test Instructor',
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.kelas.show', $kelas));

    $response->assertOk();
    $response->assertViewIs('admin.kelas.show');
    $response->assertViewHas('kelas', $kelas);
});

test('admin can view edit kelas form', function () {
    $kelas = Kelas::create([
        'name' => 'Test Kelas',
        'description' => 'Test Description',
        'instructor' => 'Test Instructor',
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.kelas.edit', $kelas));

    $response->assertOk();
    $response->assertViewIs('admin.kelas.edit');
    $response->assertViewHas('kelas', $kelas);
});

test('admin can update kelas', function () {
    $kelas = Kelas::create([
        'name' => 'Original Name',
        'description' => 'Original Description',
        'instructor' => 'Original Instructor',
    ]);

    $response = $this->actingAs($this->admin)
        ->put(route('admin.kelas.update', $kelas), [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'instructor' => 'Updated Instructor',
        ]);

    $response->assertRedirect(route('admin.kelas.index'));
    $response->assertSessionHas('success');
    
    $this->assertDatabaseHas('kelas', [
        'id' => $kelas->id,
        'name' => 'Updated Name',
        'description' => 'Updated Description',
        'instructor' => 'Updated Instructor',
    ]);
});

test('update kelas validates required fields', function () {
    $kelas = Kelas::create([
        'name' => 'Test Kelas',
        'description' => 'Test Description',
        'instructor' => 'Test Instructor',
    ]);

    $response = $this->actingAs($this->admin)
        ->put(route('admin.kelas.update', $kelas), []);

    $response->assertSessionHasErrors(['name', 'description', 'instructor']);
});

test('admin can delete kelas', function () {
    $kelas = Kelas::create([
        'name' => 'To Delete',
        'description' => 'To Delete Description',
        'instructor' => 'To Delete Instructor',
    ]);

    $response = $this->actingAs($this->admin)
        ->delete(route('admin.kelas.destroy', $kelas));

    $response->assertRedirect(route('admin.kelas.index'));
    $response->assertSessionHas('success');
    
    $this->assertDatabaseMissing('kelas', [
        'id' => $kelas->id,
    ]);
});

test('kelas index shows paginated results', function () {
    // Create more than 10 kelas to test pagination
    for ($i = 1; $i <= 15; $i++) {
        Kelas::create([
            'name' => "Kelas {$i}",
            'description' => "Description {$i}",
            'instructor' => "Instructor {$i}",
        ]);
    }

    $response = $this->actingAs($this->admin)
        ->get(route('admin.kelas.index'));

    $response->assertOk();
    $this->assertTrue($response->viewData('kelas')->count() <= 10);
});

test('unauthorized user cannot access kelas management', function () {
    $response = $this->get(route('admin.kelas.index'));

    $response->assertRedirect(route('login'));
});

test('admin can view multiple kelas in index', function () {
    Kelas::create([
        'name' => 'Kelas 1',
        'description' => 'Description 1',
        'instructor' => 'Instructor 1',
    ]);

    Kelas::create([
        'name' => 'Kelas 2',
        'description' => 'Description 2',
        'instructor' => 'Instructor 2',
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.kelas.index'));

    $response->assertOk();
    $this->assertGreaterThanOrEqual(2, $response->viewData('kelas')->count());
});

