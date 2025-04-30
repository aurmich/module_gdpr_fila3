# Traduzioni del Modulo Gdpr

## Collegamenti

- [Modulo Lang](../../Lang/docs/module_lang.md) - Documentazione principale sulle traduzioni
- [Regole Generali Traduzioni](../../Xot/docs/translations.md)

## Struttura

```
Modules/Gdpr/
└── lang/
    ├── it/
    │   └── gdpr.php
    └── en/
        └── gdpr.php
```

## Contenuto

Il file `gdpr.php` contiene le traduzioni per:
- Privacy policy
- Cookie policy
- Consensi
- Diritti utente
- Gestione dati
- Esportazione dati
- Cancellazione dati
- Notifiche privacy
- Configurazione GDPR
- Report conformità

## Esempi

```php
return [
    'privacy' => [
        'label' => 'Privacy Policy',
        'tooltip' => 'Visualizza la privacy policy'
    ],
    'cookies' => [
        'label' => 'Cookie Policy',
        'tooltip' => 'Gestisci le preferenze cookie'
    ],
    'consents' => [
        'label' => 'Consensi',
        'tooltip' => 'Gestisci i consensi degli utenti'
    ],
    'rights' => [
        'label' => 'Diritti Utente',
        'tooltip' => 'Gestisci i diritti degli utenti'
    ]
];
``` 