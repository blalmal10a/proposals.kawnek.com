## features
php artisan make:model Project -mcr
php artisan make:model FeatureGroup -mcr
php artisan make:model Feature -mcr


## projects
- name
- client_name
- description
- initiated_at [date]
- abandoned_at [date]
- created_at
- updated_at


## feature_groups
- title
- sort
- created_at
- updated_at

## features
- name
- description
- feature_group_id
- is_selected
- default_selection_value
- is_required
- required_feature_ids
- dependant_feature_ids
- cost [nullable]
- yearly_cost [nullable]
- monthly_cost [nullable]
- created_at
- updated_at



## migrations
php artisan make:filament-resource Project --view --generate --soft-deletes --force
php artisan make:filament-resource FeatureGroupResource --view --generate --soft-deletes --force
php artisan make:filament-resource FeatureResource --view --generate --soft-deletes --force
