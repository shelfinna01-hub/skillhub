<?php

use App\Models\User;
use App\Models\Kelas;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Hash;

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

    /** @var Kelas */
    $this->kelas = Kelas::create([
        'name' => 'Test Kelas',
        'description' => 'Test Description',
        'instructor' => 'Test Instructor',
    ]);
});

test('admin can view pendaftaran index page', function () {
    Pendaftaran::create([
        'user_id' => $this->peserta->id,
        'kelas_id' => $this->kelas->id,
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.pendaftaran.index'));

    $response->assertOk();
    $response->assertViewIs('admin.pendaftaran.index');
    $response->assertViewHas(['pendaftaran', 'pesertas', 'kelas']);
});

test('peserta cannot access pendaftaran management', function () {
    $response = $this->actingAs($this->peserta)
        ->get(route('admin.pendaftaran.index'));

    $response->assertStatus(403);
});

test('admin can view create pendaftaran form', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.pendaftaran.create'));

    $response->assertOk();
    $response->assertViewIs('admin.pendaftaran.create');
    $response->assertViewHas(['pesertas', 'kelas']);
});

test('admin can create new pendaftaran', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.pendaftaran.store'), [
            'user_id' => $this->peserta->id,
            'kelas_id' => $this->kelas->id,
        ]);

    $response->assertRedirect(route('admin.pendaftaran.index'));
    $response->assertSessionHas('success');
    
    $this->assertDatabaseHas('pendaftaran', [
        'user_id' => $this->peserta->id,
        'kelas_id' => $this->kelas->id,
    ]);
});

test('store pendaftaran validates required fields', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.pendaftaran.store'), []);

    $response->assertSessionHasErrors(['user_id', 'kelas_id']);
});

test('store pendaftaran validates user exists', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.pendaftaran.store'), [
            'user_id' => 99999,
            'kelas_id' => $this->kelas->id,
        ]);

    $response->assertSessionHasErrors(['user_id']);
});

test('store pendaftaran validates kelas exists', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.pendaftaran.store'), [
            'user_id' => $this->peserta->id,
            'kelas_id' => 99999,
        ]);

    $response->assertSessionHasErrors(['kelas_id']);
});

test('admin cannot register non-peserta user to kelas', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.pendaftaran.store'), [
            'user_id' => $this->admin->id,
            'kelas_id' => $this->kelas->id,
        ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');
    
    $this->assertDatabaseMissing('pendaftaran', [
        'user_id' => $this->admin->id,
        'kelas_id' => $this->kelas->id,
    ]);
});

test('admin cannot create duplicate pendaftaran', function () {
    Pendaftaran::create([
        'user_id' => $this->peserta->id,
        'kelas_id' => $this->kelas->id,
    ]);

    $response = $this->actingAs($this->admin)
        ->post(route('admin.pendaftaran.store'), [
            'user_id' => $this->peserta->id,
            'kelas_id' => $this->kelas->id,
        ]);

    $response->assertRedirect();
    $response->assertSessionHas('error', 'Sudah terdaftar');
    
    $this->assertEquals(1, Pendaftaran::where('user_id', $this->peserta->id)
        ->where('kelas_id', $this->kelas->id)
        ->count());
});

test('admin can view pendaftaran details', function () {
    $pendaftaran = Pendaftaran::create([
        'user_id' => $this->peserta->id,
        'kelas_id' => $this->kelas->id,
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.pendaftaran.show', $pendaftaran->id));

    $response->assertOk();
    $response->assertViewIs('admin.pendaftaran.show');
    $response->assertViewHas('pendaftaran');
});

test('admin can view pendaftaran by user', function () {
    Pendaftaran::create([
        'user_id' => $this->peserta->id,
        'kelas_id' => $this->kelas->id,
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.pendaftaran.show', $this->peserta->id) . '?type=user');

    $response->assertOk();
    $response->assertViewIs('admin.pendaftaran.show-user');
    $response->assertViewHas(['user', 'pendaftaran']);
});

test('admin can view pendaftaran by kelas', function () {
    Pendaftaran::create([
        'user_id' => $this->peserta->id,
        'kelas_id' => $this->kelas->id,
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.pendaftaran.show', $this->kelas->id) . '?type=kelas');

    $response->assertOk();
    $response->assertViewIs('admin.pendaftaran.show-kelas');
    $response->assertViewHas(['kelas', 'pendaftaran']);
});

test('admin can delete pendaftaran', function () {
    $pendaftaran = Pendaftaran::create([
        'user_id' => $this->peserta->id,
        'kelas_id' => $this->kelas->id,
    ]);

    $response = $this->actingAs($this->admin)
        ->delete(route('admin.pendaftaran.destroy', $pendaftaran));

    $response->assertRedirect(route('admin.pendaftaran.index'));
    $response->assertSessionHas('success');
    
    $this->assertDatabaseMissing('pendaftaran', [
        'id' => $pendaftaran->id,
    ]);
});

test('pendaftaran index can filter by user', function () {
    $anotherPeserta = User::create([
        'name' => 'Another Peserta',
        'email' => 'another@test.com',
        'password' => Hash::make('password'),
        'role' => 'peserta',
    ]);

    Pendaftaran::create([
        'user_id' => $this->peserta->id,
        'kelas_id' => $this->kelas->id,
    ]);

    Pendaftaran::create([
        'user_id' => $anotherPeserta->id,
        'kelas_id' => $this->kelas->id,
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.pendaftaran.index', ['user_id' => $this->peserta->id]));

    $response->assertOk();
    $pendaftaran = $response->viewData('pendaftaran');
    
    foreach ($pendaftaran as $p) {
        $this->assertEquals($this->peserta->id, $p->user_id);
    }
});

test('pendaftaran index can filter by kelas', function () {
    $anotherKelas = Kelas::create([
        'name' => 'Another Kelas',
        'description' => 'Another Description',
        'instructor' => 'Another Instructor',
    ]);

    Pendaftaran::create([
        'user_id' => $this->peserta->id,
        'kelas_id' => $this->kelas->id,
    ]);

    Pendaftaran::create([
        'user_id' => $this->peserta->id,
        'kelas_id' => $anotherKelas->id,
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.pendaftaran.index', ['kelas_id' => $this->kelas->id]));

    $response->assertOk();
    $pendaftaran = $response->viewData('pendaftaran');
    
    foreach ($pendaftaran as $p) {
        $this->assertEquals($this->kelas->id, $p->kelas_id);
    }
});

test('unauthorized user cannot access pendaftaran management', function () {
    $response = $this->get(route('admin.pendaftaran.index'));

    $response->assertRedirect(route('login'));
});

test('delete pendaftaran removes the registration', function () {
    $pendaftaran = Pendaftaran::create([
        'user_id' => $this->peserta->id,
        'kelas_id' => $this->kelas->id,
    ]);

    $pendaftaranId = $pendaftaran->id;

    $this->actingAs($this->admin)
        ->delete(route('admin.pendaftaran.destroy', $pendaftaran));

    $this->assertNull(Pendaftaran::find($pendaftaranId));
});

