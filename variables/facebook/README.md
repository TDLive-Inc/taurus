# Facebook variables

## private Facebook $fb

Contains the Facebook instance, initialized on a call of fbsetup().

## private String[] $fb_config

Stores the configuration array required to initialize [$fb](https://github.com/TDLive-Inc/taurus/blob/doc/variables/facebook/README.md#private-facebook-fb).

### Array Contents

appID: The application ID assigned by [Facebook Developers](http://developers.facebook.com/).

secret: The secret assigned by [Facebook Developers](http://developers.facebook.com/).

fileUploads: Taken from the settings constant [TAURUS_FILE_UPLOADS](https://github.com/TDLive-Inc/taurus/tree/doc/variables/settings#taurus_file_uploads).