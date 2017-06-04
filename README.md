# FB Pinner
FB Pinner initialy created for KSART.nl.

## Explanation of the FB Pinner flow

1. Index/Importer
Based on a ICal URL whill be a ICS file created.
The ICS File is being insert into a SQL database with the raw ICal data.
The raw database haves an is_field_mapped boolean field,
which contains is the event is already mapped.
2. Fieldmap
The raw database is being selected, where functions create a random color/brightness
or autoselect a Town/Province for KSART.nl prikkers.
This doesn't always select a correct Town/Province and needs further work.