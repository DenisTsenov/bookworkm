<?php

/*
 * user bucket expire time
 */
//  60min * 60sec = 3600sec (1 hour)
const BUCKET_LIVE = 3600;

/*
 * destroy session and log out user
 * if  LOG is  true
 * and  only destroy bucket 
 * if LOG is false
 */

const LOG = false;

