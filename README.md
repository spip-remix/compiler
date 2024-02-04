# spip/compilo

Compilateur de squelettes SPIP.

## Principes

Le compilateur est un pipeline qui va transformer un squelette en page à renvoyer à l'utilisateur.

Un pipeline est un ensemble d'étapes exécutées les unes à la suite des autres (`stages` ou `middlewares`)
et qui transforme un `payload` au fur et à mesure. C'est une forme du design pattern Composite.

Le point d'entrée actuel (SPIP4.2 et versions antérieures) du compilateur
est, grosso modo, la fonction `recuperer_fond(...)`

En gros, le nouveau pipeline remplace la fonction `evaluer_fond()` et l'appel à la fonction `pipeline('recuperer_fond', ...)`

Pour assurer la compatibilité ascendante, le corps de cette fonction pourra ressembler à:

```php
/**
 * @deprecated 5.0
 */
function recuperer_fond($fond, $contexte = [], $options = [], string $connect = '') {
    static $c = null;
    if (is_null($c)) {
        new Compilo;
    }
 
    // ...code...
    $page = [
        'texte' => '',
        'erreur' => '',
        'invaldeurs' => [],
    ];

    $squelette = file_get_content($f = find_in_path($fond.'.html'));
    $payload = [
        'page' => $f,
        'squelette' => $squelette,
        'contexte' => array_merge($contexte, $options, ['connect' => $connect])
    ];

    $payload = $c($payload);
    $page['texte'] = $payload['page'];
    // ...code...

    return [
        'args' => [/* ... f($payload) ...*/],
        'page' => $page,
    ];
}
```

### Payload

Le payload du compilateur est le suivant:

- `page`: le nom de la page demandée
  - le compilo ne traite pas les actions SPIP qui ont été traitées en amont de l'appel au compilo
    - au mieux, on peut considérer que l'appel au compilo est la conséquence d'un appel à une action *virtuelle* `page` avec un argument `page` qui vaut lui-même `sommaire` par défaut.
  - `page` correspond, en PHP, au contenu de `$_GET['page]` dans le cadre d'une requête HTTP, d'un argument d'une commande CLI  ou de tout autre argument issu d'un bus d'évènements quelconque
  - la valeur de `page` sera l'identiant du cache de niveau1
  - exemple: `prive/liste/auteurs`
- squelette: la chaine de caractères du squelette
  - en amont de l'appel au compilateur, la correspondance est faite entre `page` et la récupération du contenu d'un fichier selon une logique indépendante
- contexte: collection d'arguments optionnels qui s'enrichit au fil du processus
  - exemples: paramètres `var_mode`, `debut_xxx`, ...
- script: au fil du processus, le payload s'enrichit d'une référence au résultat de la transpilation
- rendu: au fil du processus, le payload s'enrichit du rendu résultant
- metadonnées: au fil du processus, le payload s'enrichit de metadonnées

### Étapes

Les étapes du compilateur sont les suivantes:

- Transpilation de la chaine de caractères issue d'un fichier texte donné.
  - Recherche du cache associé (fondé sur la page du payload)
    - Si le cache est absent ou invalide (ie: le fichier squelette est modifié depuis la dernière transpilation OU son ttl est dépassé OU on force le calcul)
      - Détection des éléments de syntaxe SPIP (texte non-transformé, balises, boucles, inclusions dynamiques)
      - Constitution de l'Arbre Syntaxique Abstrait (AST)
      - Génération du script à partir de l'AST
      - Mise en cache (niveau1)
    - Sinon, lecture du script dans le cache
  - Renvoi du script
- Exécution du script transpilé
  - Recherche du cache associé (fondé sur le script, le contexte, ... ?)
    - Si le cache est absent ou invalide (le script est modifié, ... ?)
      - Évaluation du script transpilé
      - Mise en cache (niveau2)
    - Sinon, lecture du rendu dans le cache
  - Renvoi de la page et des métadonnées
