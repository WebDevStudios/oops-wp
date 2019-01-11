# Changelog

## 2019-01-11
The initial dev release of OOPS-WP is up on GitHub. This version offers
the following structures:

#### Interfaces
- Hookable - implementing classes can register hooks with WordPress.
- Registerable - implementing classes can register with WordPress.
- Runnable - implementing classes can be run.

#### Traits
- FilePathDependent - classes using this trait can define a relative path to a dependency.

#### Abstract Classes
- ServiceRegistrar - extending classes can define a collection of Service classes.
- Service - extending classes can be run and register hooks with WordPress.
- Content\PostType - extending classes can register a post type with WordPress.
- Editor\EditorBlock - extending classes can provide logic for registering a block in the WordPress editor.
