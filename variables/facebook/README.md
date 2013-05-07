# Facebook variables

## private Facebook $fb

Contains the Facebook instance, initialized on a call of fbsetup().

## private String[] $fb_config

Stores the configuration array required to initialize $fb.

### Array Contents

appID: The application ID assigned by Facebook Developers.

secret: The secret assigned by Facebook Developers.

fileUploads: Taken from the settings constant TAURUS_FILE_UPLOADS.