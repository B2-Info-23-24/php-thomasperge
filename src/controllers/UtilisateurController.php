<?php

class UtilisateurController
{
  public function afficherListeUtilisateurs()
  {
    // Dans une application réelle, vous récupéreriez ces données depuis la base de données
    $utilisateurs = [
      'John Doe',
      'Jane Doe',
      'Alice',
      'Bob'
    ];

    // Appeler la vue avec les données nécessaires
    extract(['utilisateurs' => $utilisateurs]); // Extraire les variables
    include '../views/utilisateur.php';
  }
}
