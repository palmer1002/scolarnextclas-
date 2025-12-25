<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un Bulletin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Ton CSS --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
</head>
<body>

<div class="section-card">
    <h2 class="section-title">
        <i class="fas fa-plus-circle"></i>
        Créer un Nouveau Bulletin
    </h2>

    <form action="{{ route('bulletins.store') }}" method="POST">
        @csrf

        <!-- Élève & Trimestre -->
        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label for="new_student">Élève *</label>
                    <select id="new_student" name="student_id" class="form-control" required>
                        <option value="">Sélectionner un élève</option>
                        {{-- Exemple statique (à remplacer par une boucle plus tard) --}}
                        <option value="1">Amina Diallo (6ème A)</option>
                        <option value="2">Ray Kokoroko (6ème A)</option>
                        <option value="3">Arnaud Klanlenou (6ème B)</option>
                    </select>
                </div>
            </div>

            <div class="form-col">
                <div class="form-group">
                    <label for="new_trimestre">Trimestre *</label>
                    <select id="new_trimestre" name="trimestre" class="form-control" required>
                        <option value="">Sélectionner un trimestre</option>
                        <option value="t1">Trimestre 1</option>
                        <option value="t2">Trimestre 2</option>
                        <option value="t3">Trimestre 3</option>
                        <option value="s1">Semestre 1</option>
                        <option value="s2">Semestre 2</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Année & Date -->
        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label for="annee_scolaire">Année Scolaire *</label>
                    <input type="text"
                           id="annee_scolaire"
                           name="annee_scolaire"
                           class="form-control"
                           value="2025-2026"
                           required>
                </div>
            </div>

            <div class="form-col">
                <div class="form-group">
                    <label for="date_edition">Date d'Édition *</label>
                    <input type="date"
                           id="date_edition"
                           name="date_edition"
                           class="form-control"
                           required>
                </div>
            </div>
        </div>

        <!-- Matières -->
        <h4 style="color: var(--primary-color); margin-top: 30px; margin-bottom: 20px;">
            <i class="fas fa-book"></i> Ajouter des Matières
        </h4>

        <!-- Matière 1 -->
        <div class="crud-section" style="margin-bottom: 20px;">
            <h5>Matière 1</h5>

            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="matiere1_nom">Nom de la matière</label>
                        <input type="text"
                               id="matiere1_nom"
                               name="matieres[0][nom]"
                               class="form-control"
                               placeholder="Ex: Mathématiques">
                    </div>
                </div>

                <div class="form-col">
                    <div class="form-group">
                        <label for="matiere1_coef">Coefficient</label>
                        <input type="number"
                               id="matiere1_coef"
                               name="matieres[0][coef]"
                               class="form-control"
                               min="1"
                               max="10"
                               value="4">
                    </div>
                </div>
            </div>

            <div class="notes-grid">
                <div class="form-group">
                    <label>Interro 1</label>
                    <input type="number" name="matieres[0][int1]" class="form-control" min="0" max="20" step="0.5">
                </div>
                <div class="form-group">
                    <label>Interro 2</label>
                    <input type="number" name="matieres[0][int2]" class="form-control" min="0" max="20" step="0.5">
                </div>
                <div class="form-group">
                    <label>Interro 3</label>
                    <input type="number" name="matieres[0][int3]" class="form-control" min="0" max="20" step="0.5">
                </div>
                <div class="form-group">
                    <label>Interro 4</label>
                    <input type="number" name="matieres[0][int4]" class="form-control" min="0" max="20" step="0.5">
                </div>
                <div class="form-group">
                    <label>Devoir</label>
                    <input type="number" name="matieres[0][devoir]" class="form-control" min="0" max="20" step="0.5">
                </div>
                <div class="form-group">
                    <label>Composition</label>
                    <input type="number" name="matieres[0][composition]" class="form-control" min="0" max="20" step="0.5">
                </div>
            </div>
        </div>

        <!-- Commentaire -->
        <h4 style="color: var(--primary-color); margin-top: 30px; margin-bottom: 20px;">
            <i class="fas fa-comment"></i> Commentaires
        </h4>

        <div class="form-group">
            <label for="commentaire">Commentaire du Professeur Principal</label>
            <textarea id="commentaire"
                      name="commentaire"
                      class="form-control"
                      rows="4"
                      placeholder="Saisissez les commentaires et appréciations..."></textarea>
        </div>

        <!-- Actions -->
        <div class="action-buttons">
            <button type="reset" class="btn btn-warning">
                <i class="fas fa-eraser"></i> Réinitialiser
            </button>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-check-circle"></i> Créer le Bulletin
            </button>

            <a href="{{ route('bulletins.index') }}" class="btn btn-info">
                <i class="fas fa-times"></i> Annuler
            </a>
        </div>

    </form>
</div>

</body>
</html>
