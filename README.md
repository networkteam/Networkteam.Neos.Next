# Networkteam.Neos.Next

This package adds special support for Next.js to Neos CMS.

* Provides preview rendering for nodes (a.k.a. out of band rendering) through the Next.js frontend
* Send revalidation requests to Next.js for changed document nodes

> Note: Make sure to add `@networkteam/zebra` in your Next.js project.

The actual content will be provided to Next.js via the `Networkteam.Neos.ContentApi` package.

**Why two packages?**

`Networkteam.Neos.ContentApi` is a more generic package for fetching content from Neos CMS in JSON format and is
configurable via Fusion. It is not specific to Next.js and can be used for other use cases as well.

## Configuration

