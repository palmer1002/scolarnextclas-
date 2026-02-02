@extends(Auth::check() ? 'layouts.app' : 'layouts.guest')

@section('title', 'Politique de Confidentialité')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0 radius-10">
                <div class="card-body p-5">
                    <h1 class="mb-4 text-primary"><i class="fas fa-user-shield me-2"></i> Politique de Confidentialité</h1>
                    <p class="text-muted italic mb-5">Dernière mise à jour : 31 Janvier 2026</p>

                    <section class="mb-5">
                        <h4 class="fw-bold text-dark mb-3">1. Introduction</h4>
                        <p>La présente Politique de Confidentialité décrit comment <strong>ScolarNextClas</strong> collecte, utilise et protège les informations personnelles des utilisateurs (élèves, parents, enseignants et administrateurs) de notre plateforme de gestion scolaire.</p>
                    </section>

                    <section class="mb-5">
                        <h4 class="fw-bold text-dark mb-3">2. Collecte des Données</h4>
                        <p>Nous collectons les données nécessaires au bon fonctionnement de l'établissement scolaire :</p>
                        <ul>
                            <li><strong>Pour les élèves :</strong> Nom, prénom, date de naissance, classe, notes, présences et informations académiques.</li>
                            <li><strong>Pour les parents :</strong> Nom, coordonnées (téléphone, email) et lien de parenté avec l'élève.</li>
                            <li><strong>Pour les enseignants :</strong> Nom, spécialités, emploi du temps et données professionnelles.</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h4 class="fw-bold text-dark mb-3">3. Utilisation des Données</h4>
                        <p>Vos données sont utilisées exclusivement pour :</p>
                        <ul>
                            <li>La gestion administrative et pédagogique des élèves.</li>
                            <li>La communication entre l'école, les parents et les élèves.</li>
                            <li>Le suivi des paiements de scolarité.</li>
                            <li>La génération des bulletins de notes et rapports d'activité.</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h4 class="fw-bold text-dark mb-3">4. Conservation et Sécurité</h4>
                        <p>Nous mettons en œuvre des mesures de sécurité techniques et organisationnelles pour protéger vos données contre tout accès non autorisé, perte ou altération. Les données sont conservées uniquement pendant la durée de scolarisation de l'élève ou l'exercice des fonctions du personnel.</p>
                    </section>

                    <section class="mb-5">
                        <h4 class="fw-bold text-dark mb-3">5. Partage des Données</h4>
                        <p>ScolarNextClas ne vend, ne loue ni ne partage vos données personnelles avec des tiers à des fins commerciales. L'accès aux données est strictement limité au personnel autorisé de l'établissement.</p>
                    </section>

                    <section class="mb-5">
                        <h4 class="fw-bold text-dark mb-3">6. Vos Droits</h4>
                        <p>Conformément à la réglementation en vigueur, vous disposez d'un droit d'accès, de rectification et de suppression de vos données personnelles. Pour exercer ces droits, veuillez contacter l'administration de l'école.</p>
                    </section>

                    <div class="mt-5 pt-4 border-top">
                        <p class="text-center text-muted">© {{ date('Y') }} ScolarNextClas - Système de Gestion Scolaire Intégré</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retourner à la page précédente
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
