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

The Next.js URL must be known for Neos CMS for the integration to work correctly.
The default configuration works for a local Next.js server.

```yaml
Networkteam:
  Neos:
    Next:
      # Configure Next.js setting by site node name
      sites:
        # The default settings are used for all sites without a specific configuration
        _default:
          # The base URL for the Next.js frontend
          nextBaseUrl: http://localhost:3000/

          revalidate:
            # The URI for revalidation could be a path or an absolute URL
            uri: '/api/revalidate'
            token: 'a-secret-token'

        # Add additional site configurations by site node name
        #
        # mySiteNode:
        #   nextBaseUrl: http://my-site.local:3000/
```

> Note: A long random token should be used for production configuration.

## License

[MIT](./LICENSE.md)
