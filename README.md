Symfony on App Engine Flex
=================

This is a demo application for using Symfony on App Engine Flex.

See the [Run Symfony on App Engine Flex][tutorial] for a full walkthrough.

# TLDR

1. Clone this application, run `composer install`, and copy `parameters.yml.dist`:
    ```sh
    git clone git@github.com:bshaffer/symfony-on-app-engine-flex.git
    cd symfony-on-app-engine-flex
    composer install
    cp app/config/parameters.yml.dist app/config/parameters.yml
    ```
1. Create a [CloudSQL Instance][cloudsql-create] and [Run the proxy][cloudsql-install]
    ```sh
    # run the cloudsql product and use a unix socket connection for consistency.
    cloud_sql_proxy -dir /cloudsql
    ```
1. Export Environemt Variables for your CloudSQL credentials:
    ```sh
    # export your credentials
    export DB_SOCKET=/cloudsql/YOUR_PROJECT_ID\:us-central1\:symfony DB_DATABASE=symfony DB_USERNAME=root DB_PASSWORD=YOUR_CLOUDSQL_PASSWORD
    ```
1. Create and migrate your doctrine DB:
    ```sh
    # create the doctrine database
    bin/console doctrine:database:create
    # migrate the doctrine database
    bin/console doctrine:schema:update --force
    ```
1. Run the app locally and view it at `http://localhost:8080`
    ```sh
    bin/console server:run
    ```
1. Set Environemt Variables in `app.yaml` to the same CloudSQL credentials used in Step 2.
1. Deploy your app to App Engine Flexible and view it at `http://YOUR_PROJECT_ID.appspot.com`:
    ```sh
    gcloud app deploy
    ```

[tutorial]: https://cloud.google.com/community/tutorials/run-symfony-on-appengine-flexible
[cloudsql-create]: https://cloud.google.com/sql/docs/mysql/create-instance
[cloudsql-install]: https://cloud.google.com/sql/docs/mysql/connect-external-app#install
