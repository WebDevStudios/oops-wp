# OOPS-WP: Object Oriented Programming Structures for WordPress
This library provides a collection of abstract classes, interfaces,
and traits to help promote object-oriented development in WordPress.

## Installation
The preferred way to install the latest stable release of OOPS-WP is
via Composer. From your project directory, you can run:
```
composer require webdevstudios/oops-wp
```

This will install the library relative to where you called the command,
at `/vendor/webdevstudios/oops-wp`. You can navigate to that directory
to look through the various classes, interfaces, and traits that are
available for you to use. In order to make those structures available
to WordPress, you'll need to require the Composer-generated autoload file:

```
if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}
```

### A Caveat
WordPress isn't designed to be compatible with Composer, and many plugins
and themes may wind up using the same libraries. This library is
recommended for use in agency-type projects where have full control
over the development and installation environment. Including OOPS-WP
as part of a packaged release may mean that multiple different copies
could wind up getting installed and included in a project, thereby causing
unforeseen errors in the system. This is a shortcoming of the way WordPress
resolves dependencies, and not one of OOPS-WP. For more information
about this issue, [we recommend checking out this great article
on by Peter Suhm on WPTavern](https://wptavern.com/a-narrative-of-using-composer-in-a-wordpress-plugin).

## Documentation and Development Roadmap
In its initial release, OOPS-WP contains very few structures to facilitate
plugin and theme development. There are a handful of interfaces:
`Hookable`, `Runnable`, and `Registerable`, and a few abstract classes,
notably `ServiceRegistrar`, `Service`, `EditorBlock`, and `PostType`.
These were borne around the need to quickly scaffold some basic
structural entities at WebDevStudios, but they are not the only
data structures supported by WordPress.

To see what WordPress structures are under development, you can
[visit the Issues page of this repo](https://github.com/webdevstudios/oops-wp/issues).
For documentation and examples on how to use the structures this package
provides, you can [visit the Wiki](https://github.com/webdevstudios/oops-wp/wiki).

## Versioning
This project follows [semantic versioning](https://semver.org) best
practices. What this means is that PATCH releases (e.g., 0.1.1) will
include only minor bugfixes or other non-functional updates, such as
the text in this README. MINOR releases (e.g., 0.2.0) will include
new features, such as additional class structures, and backward-compatible
friendly changes. MAJOR releases (e.g., 1.0.0) will contain
changes that break backward compatibility. As such, you should be
able to safely run `composer update webdevstudios/oops-wp` on packages
that are versioned to a major release (e.g., `^1`) without worrying
that the updates will break your site. Upgrading to the next major release
will mean that you will likely have to make updates to all of the classes
that make use of this library to ensure that they're adhering to the
latest APIs.

## Contributing
See the [contributing](CONTRIBUTING.md) doc for information on
how to contribute to this project.
