<?php

use Spip\Component\Compilo\Filter\Payload\Pipeline;

require_once 'vendor/autoload.php';

echo PHP_EOL
    . 'Seule la fonction "dist" est préchargée.'
    . PHP_EOL
    . '[(#QUELCONQUE|example|n_existe_pas)] sera "compilé" en:'
    . PHP_EOL
;
$contenu_balise = 'contenu d\'une balise quelconque';
$pipeline = (new Pipeline)
    ->add(chercher_filtre('example', 'filtre_identite_dist'))
    ->add(chercher_filtre('n_existe_pas', 'filtre_identite_dist'))
;
$debug = [$contenu_balise => $pipeline->process($contenu_balise)];
echo print_tests('%s:', $debug);

require 'tests/Fixtures/perso_example.php';
echo PHP_EOL
    . 'Un plugin a préchargé la fonction example.'
    . PHP_EOL
    . '[(#QUELCONQUE|example|n_existe_pas)] sera "compilé" en:'
    . PHP_EOL
;
$pipeline = (new Pipeline)
->add(chercher_filtre('example', 'filtre_identite_dist'))
->add(chercher_filtre('n_existe_pas', 'filtre_identite_dist'))
;
$debug = [$contenu_balise => $pipeline->process($contenu_balise)];
echo print_tests('%s:', $debug);

require 'tests/Fixtures/perso_filtre_example.php';
echo PHP_EOL
    . 'Un plugin a préchargé la fonction filtre_example.'
    . PHP_EOL
    . '[(#QUELCONQUE|example|n_existe_pas)] sera "compilé" en:'
    . PHP_EOL
;
$pipeline = (new Pipeline)
    ->add(chercher_filtre('example', 'filtre_identite_dist'))
    ->add(chercher_filtre('n_existe_pas', 'filtre_identite_dist'))
;
$debug = [$contenu_balise => $pipeline->process($contenu_balise)];
echo print_tests('%s:', $debug);

require 'tests/Fixtures/perso_class_example.php';
echo PHP_EOL
    . 'Un plugin a préchargé la class Example.'
    . PHP_EOL
    . '[(#QUELCONQUE|Vendor\Filter\Example::filtre{-param1})] sera "compilé" en:'
    . PHP_EOL
;
$pipeline = (new Pipeline)
    ->add('Vendor\Filter\Example::filtre', '-param1')
;
$debug = [$contenu_balise => $pipeline->process($contenu_balise)];
echo print_tests('%s:', $debug);
exit(0);

// // Filtres identifiés dans [(#DUREE|min_sec|marqueur_des_jours{j})]
// $pipeline = (new Pipeline)
//     // ->add(fn ($p) => $p + 1)
//     // ->add(function ($payload) {
//     //     return $payload * 2;
//     // })
//     // ->add('filtre_min_sec')
//     // ->add('min_sec')
//     // ->add('jh_minsec')
//     // ->add(new \Acme\Filter\MinSecFilter)
//     // @todo 'min_sec' avec pec de filtre_<filtre>_dist/filtre_<filtre>/<filtre>
//     // ->add([\Acme\Filter\StaticMinSecFilter::class, 'filter'])
//     // ->add([new NewMinSecFilter, 'filter'])
//     // ->add('Vendor\Name\Filter::filter') // Unknown filter
//     // ->add('Acme\Filter\NewMinSecFilter::mon_filtre') // Unknown filter
//     // ->add('Acme\Filter\NewMinSecFilter') // Unknown filter
//     // ->add('Acme\Filter\StaticMinSecFilter::filter')
//     ->add('Acme\Filter\NewMinSecFilter::filter')
//     ->add('marqueur_des_jours', 'j')
//     // ->add('avec_parametres', ' un', ' deux')
// ;

// // Contenu de la balise #DUREE
// // chaque entrée du tableau représente une valeur récupérée depuis la base où d'ailleurs
// /** @var mixed $tests */
// $tests = [
//     null,
//     false,
//     true,
//     -8,
//     0,
//     0.08,
//     0.8,
//     8,
//     80,
//     800,
//     8000,
//     80_000,
//     800_000,
//     8_000_000,
//     80_000_000,
//     '8',
//     'cétrolongladémo',
//     [8, 80],
//     ['un' => 8, 'deux' => 80],
//     new class {},
//     function ($data) { return $data; }
// ];

// $lignes = [];
// $erreurs = [];
// foreach ($tests as $test) {
//     $test_value = (new MixedPayload)->convert($test);
//     $converter = Factory::createConverterFromPayload($test);
//     try {
//         $transfo = $pipeline->process(
//             new Payload($test, $converter/*, [new IntegerPayload('non-negative')]*/),
//             // false,
//         );
//         $lignes[$test_value] = $transfo;
//     } catch (\Throwable $th) {
//         $erreurs[$test_value] = $th->getMessage();
//     }
// }

// echo PHP_EOL . print_tests('Affichage pour %s secondes:', $lignes);
// echo PHP_EOL . print_tests('Erreur pour la valeur %s:', $erreurs);
