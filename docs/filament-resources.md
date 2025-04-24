# Filament Resources nel Modulo GDPR

## Struttura Base
- Tutte le Resources devono estendere `XotBaseResource`
- Implementare il metodo astratto `getFormSchema()`
- Non definire `$navigationIcon` (gestito da traduzioni)
- Non definire `table()` (gestito dalla pagina index)

## Esempio di Implementazione
```php
class ConsentResource extends XotBaseResource
{
    protected static ?string $model = Consent::class;

    public static function getFormSchema(): array
    {
        return [
            'fields' => [
                'title' => [
                    'label' => 'Titolo',
                    'tooltip' => 'Inserisci il titolo del consenso'
                ],
                'content' => [
                    'label' => 'Contenuto',
                    'tooltip' => 'Inserisci il contenuto del consenso'
                ]
            ]
        ];
    }
}
```

## Best Practices
- Utilizzare array associativi per i campi
- Includere sempre label e tooltip
- Seguire le convenzioni di traduzione
- Evitare l'uso di `->label()`
- Utilizzare il formato corretto per i campi: `'field' => ['label' => 'Etichetta', 'tooltip' => 'Descrizione']`

## Validazione
- Eseguire PHPStan per verificare la corretta implementazione
- Assicurarsi che tutti i metodi astratti siano implementati
- Verificare la tipizzazione dei dati 