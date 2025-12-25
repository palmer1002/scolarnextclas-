<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer Paiement - ScolarNextClas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .sidebar {
            width: 250px;
            background-color: #170B9DFF;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px 0;
            color: white;
            font-family: Arial, sans-serif;
        }
        .sidebar .logo {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding: 0 20px;
        }
        .sidebar .logo span {
            background: #ff6b6b;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: bold;
            color: white;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar li {
            padding: 15px 20px;
        }
        .sidebar li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .confirmation-box {
            background: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        .warning-icon {
            font-size: 4rem;
            color: #dc3545;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <span>$</span>
            <h3>ScolarNextClas</h3>
        </div>
        <ul>
            <li>
                <a href="/">
                    <i class="fas fa-chart-pie"></i> Tableau de bord
                </a>
            </li>
            <li>
                <a href="/paiement">
                    <i class="fas fa-money-bill-wave"></i> Paiement
                </a>
            </li>
        </ul>
    </div>

    <!-- Contenu principal -->
    <div class="content">
        <div class="confirmation-box">
            <div class="warning-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h2 class="mb-4">Confirmation de Suppression</h2>
            
            <p class="mb-4" id="message-confirmation">
                <!-- Le message sera chargé dynamiquement -->
            </p>
            
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <strong>Attention:</strong> Cette action est irréversible. Une fois supprimé, le paiement ne pourra pas être récupéré.
            </div>
            
            <form id="form-delete-paiement" method="POST">
                @csrf
                @method('DELETE')
                
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <a href="/paiement" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Annuler
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Confirmer la suppression
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Récupérer l'ID du paiement depuis l'URL
            const pathArray = window.location.pathname.split('/');
            const paiementId = pathArray[pathArray.length - 2];
            
            // Charger les informations du paiement
            chargerPaiement(paiementId);
            
            // Gérer la soumission du formulaire
            document.getElementById('form-delete-paiement').addEventListener('submit', function(e) {
                e.preventDefault();
                
                fetch(this.action, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Paiement supprimé avec succès');
                        window.location.href = '/paiement';
                    } else {
                        alert('Erreur: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la suppression');
                });
            });
        });

        function chargerPaiement(id) {
            fetch(`/api/paiements/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const paiement = data.data;
                        document.getElementById('message-confirmation').textContent = 
                            `Êtes-vous sûr de vouloir supprimer le paiement n°${paiement.numero_recu} pour ${paiement.eleve?.nom} ${paiement.eleve?.prenom} ?`;
                        
                        // Mettre à jour l'action du formulaire
                        document.getElementById('form-delete-paiement').action = `/paiements/${id}`;
                    } else {
                        document.getElementById('message-confirmation').textContent = 
                            'Paiement non trouvé';
                        document.getElementById('form-delete-paiement').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    document.getElementById('message-confirmation').textContent = 
                        'Erreur lors du chargement des informations du paiement';
                });
        }
    </script>
</body>
</html>