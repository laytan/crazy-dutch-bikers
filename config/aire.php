<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Grouping Behavior
    |--------------------------------------------------------------------------
    |
    | Elements that can be grouped (like <input> tags) are grouped by default.
    | You can disable this on an element-by-element basis by using the
    | `withoutGroup()` method, but if you would like to turn grouping off
    | by default, you can set this configuration value.
    |
     */
    'group_by_default' => true,

    /*
    |--------------------------------------------------------------------------
    | Automatically generate input IDs
    |--------------------------------------------------------------------------
    |
    | If an input does not have an "id" attribute set, Aire can automatically
    | create one. This improves UX by ensuring that <label> tags are always
    | associated with the correct tag.
    |
     */
    'auto_id' => true,

    /*
    |--------------------------------------------------------------------------
    | Default to Verbose Summaries
    |--------------------------------------------------------------------------
    |
    | By default, the Summary element will only display a message about the
    | number of errors that need to be resolved. If you would like, you can
    | change the default behavior to also include an enumerated list of the
    | errors in the summary box.
    |
     */
    'verbose_summaries_by_default' => false,

    /*
    |--------------------------------------------------------------------------
    | Default Client-Side Validation
    |--------------------------------------------------------------------------
    |
    | Aire comes with built-in client-side validation. By default, it is
    | enabled when available. You can disable this on a form-by-form basis
    | by using the `withoutValidation()` method, but if you would like to turn
    | off validation by default, you can set this configuration value.
    |
     */
    'validate_by_default' => true,

    /*
    |--------------------------------------------------------------------------
    | Client-Side Validation Scripts
    |--------------------------------------------------------------------------
    |
    | For easiest integration, Aire will inline the javascript necessary to
    | perform client-side validation. You can instead publish the JS scripts
    | and load them via `<script>` tags to take advantage of HTTP caching.
    |
     */
    'inline_validation' => true,
    'validation_script_path' => env('APP_URL') . '/js/aire/aire.js',

    /*
    |--------------------------------------------------------------------------
    | Client-Side Validation Localization
    |--------------------------------------------------------------------------
    |
    | The client-side validation of aire is English by default.
    | If you wish to change it you can download a language file from:
    | https://unpkg.com/browse/validatorjs/dist/lang/
    |
    | Aire uses this script when validation_lang_path is changed to it's URL
    | and validation_lang_locale is changed to the desired locale.
    |
    | Aire also allows you to change the attribute names to something more
    | "friendly" in error messages by adding them to validation_custom_attributes.
    | The keys should be the actual attribute name and the values will be what is
    | displayed.
    |
     */
    'validation_lang_locale' => 'nl',
    'validation_lang_path' => '/lang/nl.js',
    'validation_custom_attributes' => [
        'address' => 'adres',
        'age' => 'leeftijd',
        'amount' => 'bedrag',
        'available' => 'beschikbaar',
        'city' => 'stad',
        'content' => 'inhoud',
        'country' => 'land',
        'currency' => 'valuta',
        'date' => 'datum',
        'date_of_birth' => 'geboortedatum',
        'day' => 'dag',
        'duration' => 'tijdsduur',
        'email' => 'e-mailadres',
        'excerpt' => 'uittreksel',
        'first_name' => 'voornaam',
        'gender' => 'geslacht',
        'group' => 'groep',
        'hour' => 'uur',
        'last_name' => 'achternaam',
        'lesson' => 'les',
        'message' => 'bericht',
        'minute' => 'minuut',
        'mobile' => 'mobiel',
        'month' => 'maand',
        'name' => 'naam',
        'password' => 'wachtwoord',
        'password_confirmation' => 'wachtwoordbevestiging',
        'phone' => 'telefoonnummer',
        'price' => 'prijs',
        'second' => 'seconde',
        'sex' => 'geslacht',
        'size' => 'grootte',
        'street' => 'straatnaam',
        'student' => 'student',
        'subject' => 'onderwerp',
        'teacher' => 'Docent',
        'time' => 'tijd',
        'title' => 'titel',
        'username' => 'gebruikersnaam',
        'year' => 'jaar',
        'password-old' => 'oud wachtwoord',
        'password-new' => 'nieuw wachtwoord',
        'location' => 'locatie',
        'location_link' => 'locatie link',
        'facebook_link' => 'facebook link',
        'end_date' => 'eind datum',
        'end_time' => 'eind tijd',
        'picture' => 'foto',
        'profile_picture' => 'profielfoto',
        'description' => 'beschrijving',
        'postal_code' => 'postcode',
        'town' => 'plaats',
        'generate-password' => 'Genereer een willekeurig wachtwoord',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Attributes
    |--------------------------------------------------------------------------
    |
    | If you would like to configure default attributes for certain elements,
    | you can do so here (for example, setting a <form>'s method to 'GET' by
    | default).
    |
     */
    'default_attributes' => [
        'form' => [
            'method' => 'POST',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Classes
    |--------------------------------------------------------------------------
    |
    | If you would like to configure default CSS class names for certain elements,
    | you can do so here (for example, changing all <input> elements to have
    | the class .form-control for Bootstrap compatibility).
    |
    | These should be in the format '[element]' => '[class names]'
    | e.g. 'checkbox_label' => 'font-bold'
    |
    | See default-theme.php for a full example of configuring class names.
    |
     */
    'default_classes' => [
        'input' => 'bg-cdbb text-cdblg border-cdblg',
        'summary' => 'alert alert-danger',
        'textarea' => 'bg-cdbb text-cdblg border-cdblg',
        'form' => 'bg-cdbg-opaque p-3',
        'group_errors' => 'text-danger text-sm',
        'select' => 'bg-cdbb text-cdblg border-cdblg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Variant Classes
    |--------------------------------------------------------------------------
    |
    | Some themes may define variants, such as "sm" or "lg" or "primary".
    | If you need to override any of these, do so here.
    |
     */
    'variant_classes' => [],

    /*
    |--------------------------------------------------------------------------
    | Validation Classes
    |--------------------------------------------------------------------------
    |
    | A grouped element can optionally have a validation state set. This can
    | be not validated, invalid, or valid. You can configure these class names
    | on an element-by-element basis here.
    |
    | These should be in the format '[element]_[sub element]' => '[class names]'
    | e.g. 'checkbox_label' => 'font-bold'
    |
    | See default-theme.php for a full example of configuring class names.
    |
     */
    'validation_classes' => [

        /*
        |--------------------------------------------------------------------------
        | Not Validated
        |--------------------------------------------------------------------------
        |
        | These classes will be applied to elements that have not been validated.
        |
        | These should be in the format '[element]' => '[class names]'
        | e.g. 'checkbox_label' => 'font-bold'
        |
        | See default-theme.php for a full example of configuring class names.
        |
         */
        'none' => [],

        /*
        |--------------------------------------------------------------------------
        | Valid
        |--------------------------------------------------------------------------
        |
        | These classes will be applied to elements that have passed validation.
        |
        | These should be in the format '[element]' => '[class names]'
        | e.g. 'checkbox_label' => 'font-bold'
        |
        | See default-theme.php for a full example of configuring class names.
        |
         */
        'valid' => [],

        /*
        |--------------------------------------------------------------------------
        | Invalid
        |--------------------------------------------------------------------------
        |
        | These classes will be applied to elements that failed validation.
        |
        | These should be in the format '[element]' => '[class names]'
        | e.g. 'checkbox_label' => 'font-bold'
        |
        | See default-theme.php for a full example of configuring class names.
        |
         */
        'invalid' => [],
    ],

];
