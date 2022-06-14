#!/bin/bash
#/usr/bin/rr serve -w /code/api -c /code/docker/php/api.rr.yaml > /dev/null 2>&1 &
/usr/bin/rr serve -w /code/public -c /code/docker/php/public.rr.yaml
