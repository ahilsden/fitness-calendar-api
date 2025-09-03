# Fitness Calendar API / Http client for Strava API

A Laravel backend which acts as both an API for an Angular SPA (https://github.com/ahilsden/fitness-calendar-client) and an Http client for the third-party Strava API. In terms of the latter, only a partial OAuth flow is required; a user will already be authenticated via Sanctum so will only need to login to Strava 'on demand' to fetch the Strava activities which will then be immediately persisted. As such, handling of access tokens / refresh tokens is not required.
