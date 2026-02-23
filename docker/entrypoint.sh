#!/bin/bash
# Start supervisor
service supervisor start

# Start Apache
apache2-foreground
