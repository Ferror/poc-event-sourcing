# PoC Event Sourcing

## Event Sourcing

Event Sourcing is a pattern of persisting data in form of events. 

## Questions

1. Does creation of aggregate publishes event?
?

2. Does Repository save aggregate?
?
It seems like Repository is created to load and save aggregate, but
inside of Repository the EventStore handles loading and persisting events.

## Versions

* [V1](src/V1/README.md)
* [V2](src/V2/README.md)
