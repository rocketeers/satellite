# Satellite

Satellite is an on-server assistant for Rocketeer.
It allows you to integrate Rocketeer into your CI process by creating/updating releases from the server itself, and provide an easy-to-use interface to hook into in build processes and SCM hooks.

## Setup

To setup Satellite on your server, simply run `composer global require rocketeers/satellite`, you'll then have a `~/.composer/vendor/bin/satellite` vendor on your server you can access.
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

To create a new release of an application on your server, run `satellite deploy {your_app}`. This can be called from a git hook, or a PaaS deploy routine, etc.

To follow the deployment from your local application, first install the satellite plugin in your local application:

```bash
$ rocketeer plugin:install rocketeers/rocketeer
```

You'll then have a `tail` command available:

```bash
$ rocketeer satellite:tail
```

Which will print the progress of the deploy as it runs.
