<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GroupMessage;
use App\Models\User;

class GroupMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer quelques utilisateurs
        $users = User::where('status', 'active')->take(3)->get();

        if ($users->count() < 1) {
            $this->command->warn('Aucun utilisateur actif trouvé pour créer des messages de test.');
            return;
        }

        // Messages de bienvenue
        $messages = [
            'Bienvenue dans la discussion générale ! 👋',
            'N\'hésitez pas à partager vos idées et questions ici.',
            'Ce canal est ouvert à tous les membres de l\'établissement.',
        ];

        foreach ($messages as $index => $messageText) {
            $user = $users->random();
            GroupMessage::create([
                'user_id' => $user->id,
                'message' => $messageText,
                'created_at' => now()->subMinutes(30 - ($index * 5)),
            ]);
        }

        $this->command->info('Messages de discussion générale créés avec succès !');
    }
}
