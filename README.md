# ifttt-uber-monzo

This script is an IFTTT Webhook service that can be used as an action from an Uber "ride completed" trigger.

## How to install

TBC

## How to set up the Applet

1. Create an IFTTT account and associate it with your Uber account
2. Click to create a new Applet
3. For the trigger service, select "Uber" and the "Ride completed" trigger
4. Choose appropriate pickup/dropoff locations (most likely "Anywhere")
5. For the action service, select "Webhook" and the "Make a web request" action
6. Enter the URL in the format `https://username:password@example.com`
7. Select POST method and `application/x-www-form-url-encoded` content type
8. Set the body to the following:

```CompletedAt={{CompletedAt}}&RideType={{RideType}}&VehicleMakeModel={{VehicleMakeModel}}&VehicleLicensePlate={{VehicleLicensePlate}}&DriverName={{DriverName}}&DriverPhoneNumber={{DriverPhoneNumber}}&DriverPhoto={{DriverPhoto}}&SurgeMultiplier={{SurgeMultiplier}}&PickupLat={{PickupLat}}&PickupLong={{PickupLong}}&DropoffLat={{DropoffLat}}&DropoffLong={{DropoffLong}}&TripMapImage={{TripMapImage}}```

9. Save the Applet.
