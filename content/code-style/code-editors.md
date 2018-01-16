# Code editors

Preferred code editors are sublime and PHPstorm. The editor MUST be configured for at least

1. `.editorconfig` file support
1. UNIX style line endings

This would ensure most of the coding style are implemented without any manual interventions.

## Sublime text
To enable the automatic settings based on the editorconfig file, following plugin should be installed and activated
[https://github.com/sindresorhus/editorconfig-sublime](https://github.com/sindresorhus/editorconfig-sublime)

And to the enable the UNIX style line endings, following option should be added to the user’s settings file
`"default_line_ending": "unix",`
