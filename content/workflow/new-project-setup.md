# New Project Setup

## Git Repository

If you're creating a [Laravel](https://laravel.com) application that requires a backend, you should look into using the [aecor starter repository](https://github.com/hardikaecor/aecor-laravel-starter) as the base of your project. First clone its main repository and remove the `.git` folder. This will be the base application for your new project.

Create a repository on the on GitHub using the [repo naming rules](https://guidelines.spatie.be/workflow/version-control#repo-naming-conventions).

Example: `hardikaecor/fleetmastr.com`

Lastly, update the `.env.example` file with values relevant to the project (database name, app url, etc.)

## QA Server

1. Provision a new server on Forge. Use the domain name for the droplet (example: `fleetmastr.aecordigital.com`)
1. Create a new site with root `/current/public`
1. Ensure the name of the database makes sense
1. Update the relevant `.env` variables. Don't forget to add the necessary service API keys later.

## Services

If the project uses any third party services, you should update the README file with the exact details of the service that is used and a note on how to setup the service when moving to a new environment like QA or PROD.

1. Create a new **Sendgrid** API key
1. Create a new **Google Analytics** property
1. Create a new **Google Tag Manager** container
    - Create a constant containing the Universal Analytics ID
    - Set up a tag for Google Analytics pageviews
