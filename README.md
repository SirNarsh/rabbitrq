# WORK IN PROGRESS | NOT PRODUCTION READY 
Also OPEN FOR SUGGESTIONS & COLLABORATION

# rabbitrq
Rabbit RQ (Rabbit Requeue), A backup, re-queue &amp; data persistence system for rabbitmq, helpful for auditing, microservice rebuilds after bug fixes and more...


# Concept
Save every message sent to every exchange point, with timestamp to be able to resend those messages to new micro-services or fixed microservice that consumed the message incorrectly,
Also help in reviewing/auditing how a microservice reacted to a message

