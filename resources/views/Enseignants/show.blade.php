<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Details</title>
</head>
<body>

    <div id="teacherDetailsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="teacherDetailsTitle" style="color: #170B9DFF;"></h2>
                <button class="close-modal" onclick="closeTeacherDetailsModal()">&times;</button>
            </div>
            <div id="teacherDetailsContent">
                <!-- Les détails seront chargés ici par JavaScript -->
            </div>
        </div>
    </div>

    <script>
        // Fonctions pour la modal d'ajout
        function openAddTeacherModal() {
            document.getElementById('addTeacherModal').style.display = 'block';
        }

        function closeAddTeacherModal() {
            document.getElementById('addTeacherModal').style.display = 'none';
            document.getElementById('teacherForm').reset();
        }

        // Gestion du formulaire
        document.getElementById('teacherForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Récupérer les valeurs du formulaire
            const title = document.getElementById('teacherTitle').value;
            const lastName = document.getElementById('teacherLastName').value;
            const firstName = document.getElementById('teacherFirstName').value;
            const subject = document.getElementById('teacherSubject').value;
            
            // Simulation d'enregistrement
            alert(`Enseignant ajouté avec succès:\n\n${title} ${lastName} ${firstName}\nMatière: ${subject}`);
            
            // Fermer la modal et réinitialiser le formulaire
            closeAddTeacherModal();
        });

        // Fonctions pour la modal de détails
        function viewTeacherDetails(teacherName) {
            document.getElementById('teacherDetailsTitle').textContent = teacherName;
            
            // Simuler des données
            const detailsContent = `
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <h4 style="color: #170B9DFF; margin-bottom: 15px;">Informations personnelles</h4>
                        <p><strong>Matricule:</strong> MAT001</p>
                        <p><strong>Date d'embauche:</strong> 01/09/2020</p>
                        <p><strong>Statut:</strong> Permanent</p>
                        <p><strong>Diplôme:</strong> Master en Mathématiques</p>
                    </div>
                    <div>
                        <h4 style="color: #170B9DFF; margin-bottom: 15px;">Contact</h4>
                        <p><strong>Email:</strong> j.kouadio@school.com</p>
                        <p><strong>Téléphone:</strong> +225 07 12 34 56</p>
                        <p><strong>Adresse:</strong> Abidjan, Côte d'Ivoire</p>
                    </div>
                </div>
                
                <div style="margin-top: 20px;">
                    <h4 style="color: #170B9DFF; margin-bottom: 15px;">Classes enseignées</h4>
                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        <span class="class-badge" style="font-size: 14px;">6ème A (12h/sem)</span>
                        <span class="class-badge" style="font-size: 14px;">5ème B (8h/sem)</span>
                        <span class="class-badge" style="font-size: 14px;">Terminale C (10h/sem)</span>
                        <span class="class-badge" style="font-size: 14px;">1ère D (6h/sem)</span>
                    </div>
                </div>
                
                <div style="margin-top: 20px;">
                    <h4 style="color: #170B9DFF; margin-bottom: 15px;">Notes récentes</h4>
                    <p>Dernière évaluation: 15/10/2024</p>
                    <p>Nombre d'élèves: 145</p>
                    <p>Moyenne générale de ses classes: 14.2/20</p>
                </div>
            `;
            
            document.getElementById('teacherDetailsContent').innerHTML = detailsContent;
            document.getElementById('teacherDetailsModal').style.display = 'block';
        }

        function closeTeacherDetailsModal() {
            document.getElementById('teacherDetailsModal').style.display = 'none';
        }

        // Fermer les modales en cliquant en dehors
        window.onclick = function(event) {
            const addModal = document.getElementById('addTeacherModal');
            const detailsModal = document.getElementById('teacherDetailsModal');
            
            if (event.target == addModal) {
                addModal.style.display = 'none';
            }
            if (event.target == detailsModal) {
                detailsModal.style.display = 'none';
            }
        }

        // Recherche en temps réel
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.table-teachers tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>

    
</body>
</html>