# FB Pinner
FB Pinner initialy created for KSART.nl. The pinboard can be found on http://www.ksart.nl/pinboard.

## Flow explanation

1. Index/Importer
An ICS file will be created based on an ICal URL.
The raw data from the file will be inserted into a SQL database.
The boolean field is_field_mapped is being used to know if a record is already mapped.

2. Fieldmap
From the raw database records will be mapped, with functions that also
create random color/brightness or autoselect town/provinces for KSART.nl prikkers.
Please notice that towns/provinces will not always be correct, and actually needs further work.