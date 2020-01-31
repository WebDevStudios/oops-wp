# Changelog
## X.X.X
- Fix issue with Shortcode structure that prevented processing of attributes and content.

## 0.2.0
- Introduces new abstract classes and interfaces to the library.
- Updates PostType abstract class to extend from ContentType abstract.
- Previous PostType registration methods marked as deprecated for removal in future release.
- Fixes order of operations call in array_merge in PostType class.
- ServiceRegistrar now caches instantiated Service objects to the $service property.
- New structure-specific interfaces introduced for better type-hinting in projects.

#### New Abstract Classes
- ContentType
- Taxonomy
- Plugin
- Shortcode

#### New Interfaces
- ContentTypeInterface
- EditorBlockInterface
- PluginInterface
- Renderable - implementing classes can render.
- ShortcodeInterface

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
