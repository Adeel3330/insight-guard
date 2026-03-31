## DOMPDF Wrapper for Laravel

### Laravel wrapper for [Dompdf HTML to PDF Converter](https://github.com/dompdf/dompdf)

[![Tests](https://github.com/adeel3330/insight-guard/actions/workflows/run-test.yml/badge.svg)](https://github.com/adeel3330/insight-guard/actions) 


## Installation

### Laravel

Require the package via composer:

``` 
composer require adeel3330/insight-guard 
```

Publish views & config (optional, for customizing the dashboard):

``` 
php artisan vendor:publish --tag=views
php artisan vendor:publish --tag=config
```
  
## Features

### Security Analysis
- Detect controllers with missing validation
- Detect routes without authentication/middleware
- Warn about sensitive data exposure

### Performance Analysis
- Detect N+1 queries and suggest eager loading
- Suggest caching opportunities (response, model, query)
- Analyze query execution times and recommend indexes

### Database & Model Suggestions
- Detect unused columns or tables
- Suggest missing indexes or relationships
- Detect potential data integrity issues

### Code & Config Optimization
- Suggest route caching, config caching, and middleware improvements
- Detect slow boot services and heavy providers
- Actionable suggestions for developers


## Using the Dashboard

Visit the web dashboard in your browser:

 ``https://yourapp.test/insightguard``

Export reports in PDF or JSON:

# PDF export
``https://yourapp.test/insightguard/export/pdf``

# JSON export
``https://yourapp.test/insightguard/export/json``

## Example Usage in Controllers

```php
use Adeel3330\InsightGuard\Services\{
    RequestInspector,
    ModelAnalyzer,
    CodeOptimizer
};

// Inspect requests for validation, security, and performance issues
$issues = (new RequestInspector())->inspect($request);

// Analyze a model for DB suggestions
$modelIssues = (new ModelAnalyzer())->analyzeModel(new \App\Models\User());

// Analyze routes & controllers for code optimization
$codeIssues = (new CodeOptimizer())->analyzeRoutes();
Configuration (Optional)
// config/insightguard.php
return [
    'dashboard_prefix' => 'insightguard',
    'auth_middleware' => ['web', 'auth'],
    'export_pdf' => true,
    'export_json' => true,
    'modules' => [
        'security' => true,
        'performance' => true,
        'database' => true,
        'code' => true,
    ],
];
```

## Publish config:

```php
php artisan vendor:publish --tag=config
```

## Folder Structure

``
app/
└── GraphQL/
    └── Resolvers/
vendor/
└── adeel3330/insight-guard/
    ├── src/
    │   ├── Services/
    │   ├── Helpers/
    │   └── Dashboard/
    └── routes/web.php

``

## Philosophy

- Minimal, Laravel-style developer experience
- Actionable suggestions for security, performance, and DB
- Easy to integrate into any Laravel project
- No heavy dependencies

## License

MIT License – Open-source software.
See MIT License
