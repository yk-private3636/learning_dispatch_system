#!/bin/bash


exeDir=`dirname ${0}`

ls -1 ${exeDir} | grep -v $(basename $0) |xargs -i cp -a ${exeDir}/{} ./.git/hooks/ 

chmod +x ./.git/hooks/*
