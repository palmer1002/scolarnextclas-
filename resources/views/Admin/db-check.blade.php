<!DOCTYPE html>
<html>
<head>
    <title>Vérification Base de Données</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
        table { border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Vérification Base de Données ScolarNextClas</h1>
    
    <?php
    try {
        echo "<h2>1. Connexion à la base de données</h2>";
        DB::connection()->getPdo();
        echo "<p class='success'>✓ Connexion réussie</p>";
        echo "<p>Base de données: " . DB::connection()->getDatabaseName() . "</p>";
        
        echo "<h2>2. Tables</h2>";
        $tables = DB::select('SHOW TABLES');
        echo "<p>Nombre de tables: " . count($tables) . "</p>";
        
        echo "<table>";
        echo "<tr><th>Table</th><th>Lignes</th></tr>";
        
        foreach ($tables as $table) {
            $tableName = $table->{'Tables_in_' . DB::connection()->getDatabaseName()};
            $count = DB::table($tableName)->count();
            echo "<tr>";
            echo "<td>" . $tableName . "</td>";
            echo "<td>" . $count . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<h2>3. Données des élèves</h2>";
        $eleves = DB::table('eleves')->get();
        
        if ($eleves->count() > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Matricule</th><th>Nom</th><th>Prénom</th><th>Classe</th><th>Date Inscription</th></tr>";
            
            foreach ($eleves as $eleve) {
                echo "<tr>";
                echo "<td>" . $eleve->id . "</td>";
                echo "<td>" . $eleve->matricule . "</td>";
                echo "<td>" . $eleve->nom . "</td>";
                echo "<td>" . $eleve->prenom . "</td>";
                echo "<td>" . $eleve->classe . "</td>";
                echo "<td>" . $eleve->date_inscription . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='info'>Aucun élève dans la base de données</p>";
        }
        
        echo "<h2>4. Données des notes</h2>";
        $notes = DB::table('notes')->get();
        
        if ($notes->count() > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Élève ID</th><th>Trimestre</th><th>Matière</th><th>Note</th><th>Coefficient</th></tr>";
            
            foreach ($notes as $note) {
                echo "<tr>";
                echo "<td>" . $note->id . "</td>";
                echo "<td>" . $note->eleve_id . "</td>";
                echo "<td>" . $note->trimestre . "</td>";
                echo "<td>" . $note->matiere . "</td>";
                echo "<td>" . $note->note . "</td>";
                echo "<td>" . $note->coefficient . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='info'>Aucune note dans la base de données</p>";
        }
        
        echo "<h2>5. Test d'insertion</h2>";
        echo "<button onclick='testInsert()'>Tester l'insertion</button>";
        echo "<div id='testResult'></div>";
        
    } catch (Exception $e) {
        echo "<p class='error'>✗ Erreur: " . $e->getMessage() . "</p>";
    }
    ?>
    
    <script>
    function testInsert() {
        fetch('/api/dashboard/eleves', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                matricule: 'TEST_' + Date.now(),
                nom: 'Test',
                prenom: 'Insertion',
                classe: 'Test Classe',
                genre: 'Masculin',
                contact_parent: '+228 00 00 00 00'
            })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('testResult').innerHTML = 
                data.success ? 
                '<p class="success">✓ Insertion réussie: ' + data.data.matricule + '</p>' : 
                '<p class="error">✗ Erreur: ' + data.message + '</p>';
            
            // Recharger la page après 2 secondes pour voir la nouvelle donnée
            setTimeout(() => location.reload(), 2000);
        })
        .catch(error => {
            document.getElementById('testResult').innerHTML = 
                '<p class="error">✗ Erreur de requête: ' + error + '</p>';
        });
    }
    </script>
</body>
</html>