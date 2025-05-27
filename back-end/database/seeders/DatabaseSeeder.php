<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MovieFavorite;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
        ]);


        MovieFavorite::create([
            'user_id' => $admin->id,
            'tmdb_id' => 1098006,
            'title' => 'A Fonte da Juventude',
            'poster_path' => '/hzuWNKN19wzVsjH1RtJXzjat5Tb.jpg',
            'genre_ids' => [12, 14, 9648],
            'release_date' => '2025-05-19',
            'overview' => 'Um gênio da caça ao tesouro reúne uma equipe para uma aventura que pode mudar sua vida. Mas para enganar e fugir das ameaças a cada passo, ele precisará de alguém ainda mais inteligente do que ele: sua distante irmã.',
            'vote_average' => 6.5,
        ]);
    }
}
