# Satellite

Satellite is an on-server assistant for Rocketeer.
It allows you to integrate Rocketeer into your CI process by creating/updating releases from the server itself, and to virtually deploy from anywhere.

## Setup

### Via the global PHAR

$ wget http://rocketeer.autopergamene.eu/versions/satellite.phar
$ chmod +x satellite.phar
$ mv satellite.phar /usr/local/bin/satellite

### Via Composer

Simply run `composer global require rocketeers/satellite`, you'll then have a `~/.composer/vendor/bin/satellite` vendor on your server you can access.
Once this is done, run `satellite setup` to create the Satellite folder on the server.

## Usage

To see which applications are deployed on a particular server, run `satellite apps`:

```
+---------------+--------------------+---------------------+
| Application   | Number of releases | Latest release      |
+---------------+--------------------+---------------------+
| foobar        | 3                  | 2015-01-19 17:57:36 |
+---------------+--------------------+---------------------+
```

To create a new release of an application on your server, run `satellite deploy {your_app}`. This can be called from an SCM hook, a PaaS deploy routine, etc.

To follow the deployment from your local application, first install the satellite plugin in your local application by running:

```bash
$ rocketeer plugin:install rocketeers/satellite
```

Then add Satellite to your plugins in `config.php`:

```php
// The plugins to load
'plugins'          => array(
    'Rocketeer\Satellite\SatellitePlugin',
),
```

You'll then have a `tail` command available:

```bash
$ rocketeer satellite:tail
```

Which will print the progress of the deploy as it runs.
