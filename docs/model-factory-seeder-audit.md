# Model/Factory/Seeder Audit

Generated: 2025-08-22 16:28

## Coverage
| Model | Factory | Seeded |
|---|---|---|
| Profile | yes | no |
| Consent | yes | no |
| HasGdpr | no | no |
| Treatment | yes | no |
| Event | yes | no |

Seeder: `database/seeders/GdprDatabaseSeeder.php`

## Missing / Actions
- Add exemplar seeding in `GdprDatabaseSeeder` for: Consent, Treatment, Event, Profile (minimal realistic records).
- `HasGdpr`: infrastructural; exclude from factory/seeding.

## Likely non-business-critical
- `HasGdpr` (behavioral/trait-like). Documented as infra.
