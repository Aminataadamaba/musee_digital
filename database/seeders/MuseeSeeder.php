<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
 use Illuminate\Database\Seeder;
 use App\Models\Categorie;
 use App\Models\Artiste;
 use App\Models\Oeuvre;
// use Illuminate\Database\Seeder;

class MuseeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    


 // Catégories
 $categories = [
 ['nom' => 'Peinture', 'slug' => 'peinture', 'icone' => ' ', 'couleur' => '#FF6B6B'],
 ['nom' => 'Sculpture', 'slug' => 'sculpture', 'icone' => ' ', 'couleur' => '#4ECDC4'],
 ['nom' => 'Photographie', 'slug' => 'photographie', 'icone' => '
 ', 'couleur' => '#95E1D3'],
 ['nom' => 'Art Contemporain', 'slug' => 'art-contemporain', 'icone' => ' ', 'couleur' => '#F38181'],
 ];
 foreach ($categories as $cat) {
 Categorie::create($cat);
 }
 // Artistes
 $artistes = [
 [
 'nom' => 'Senghor',
 'prenom' => 'Léopold Sédar',
 'biographie' => 'Poète et homme d\'État sénégalais',
 'nationalite' => 'Sénégalaise'
 ],
 [
 'nom' => 'Tall',
 'prenom' => 'Papa Ibra',
 'biographie' => 'Sculpteur sénégalais renommé',
 'nationalite' => 'Sénégalaise'
 ],
 ];
 foreach ($artistes as $artiste) {
 Artiste::create($artiste);
 }
// Œuvres
 $oeuvres = [
 [
 'titre' => 'Monument de la Renaissance Africaine',
 'artiste_id' => 2,
 'categorie_id' => 2,
 'description' => 'Sculpture monumentale symbolisant l\'émergence de l\'Afrique',
 'annee_creation' => '2010',
 'qr_code' => 'QR_RENAISSANCE_001',
 'salle' => 'Hall Principal',
 'est_visible' => true,
 'est_vedette' => true,
 ],
 [
 'titre' => 'Éthiopiques',
 'artiste_id' => 1,
 'categorie_id' => 1,
 'description' => 'Recueil de poèmes célébrant la culture africaine',
 'annee_creation' => '1956',
 'qr_code' => 'QR_ETHIOPIQUES_002',
 'salle' => 'Salle de Littérature',
 'est_visible' => true,
 'est_vedette' => true,
 ],
 ];
 foreach ($oeuvres as $oeuvre) {
 Oeuvre::create($oeuvre);
 }
 
 }
}
