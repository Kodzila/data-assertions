# Data assertions

This library helps to deal with asserting proper structure returned via array. Main usage are E2E tests where entities 
are returned in non-strict way.

# Usages

## Validate structure of single entity

Consider an example: There is a webservice which returns a single note.
Structure of the note should be as follows:

Resource Note:
- @id: iri
- title: string
- description: string
- location: GeoLocation
- startDate: string
- endDate: string
- personal: boolean
- content: iri
- author: iri
- createdAt: string

You can write assertions in that way:
```php
use Kodzila\DataAssertions\EntityAssertion;

$noteData = $webService->getNote();

$assertions = EntityAssertion::build($noteData);
$assertions->field('@id')->iri();
$assertions->field('title')->string();
$assertions->field('description')->string();
$assertions->field('location')->entity();
$assertions->field('startDate')->string();
$assertions->field('endDate')->string();
$assertions->field('personal')->bool();
$assertions->field('content')->iri();
$assertions->field('author')->iri();
$assertions->field('createdAt')->string();
```

It will accept data like that:
```php
$noteData = [
    '@id' => '/api/note/dd85948e-6573-4d66-b743-cca4835448e9',
    'title' => 'Note title',
    'description' => 'Note title',
    'location' => [
        'lat' => 1,
        'lng' => 2,
        'name' => 'Kodzila note',
    ],
    'startDate' => '2020-04-06T00:00:00+02:00',
    'endDate' => '2020-04-10T00:00:00+02:00',
    'personal' => true,
    'content' => '/api/projects/dd85948e-6573-4d66-b743-cca4835448e9',
    'author' => '/api/people/b1a93fec-45f1-461f-a93b-b7d2497e9eeb',
    'createdAt' => '2020-09-14T12:55:17+02:00',
];
```

## Validate structure of entity collection
Beside single entity, the often scenario is to hit an endpoint with collection of entities.

Consider an endpoint GET /notes with returned structure:

Resource SimpleNote:
- @id: iri
- title: string
- description: string
- location: GeoLocation
- startDate: string
- endDate: string
- personal: boolean
- content: iri
- author: iri
- createdAt: string

You can write assertions in that way:
```php
use Kodzila\DataAssertions\EntityAssertion;

$notesData = $webService->getNotes();

EntityCollectionAssertion::build($notesData)
    ->each(function (EntityAssertion $entityAssertion): void {
        $entityAssertion->field('@id')->iri();
        $entityAssertion->field('title')->string();
        $entityAssertion->field('description')->string();
    });
```

It will accept data like that:
```php
$notesData = [
    [
        '@id' => '/api/note/dd85948e-6573-4d66-b743-cca4835448e9',
        'title' => 'Note title',
        'description' => 'Note title',
    ],
    [
        '@id' => '/api/note/b1a93fec-45f1-461f-a93b-b7d2497e9eeb',
        'title' => 'Note title 2',
        'description' => 'Note title 2',
    ],
];
```
