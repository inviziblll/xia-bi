'use strict'
const merge = require('webpack-merge')
const prodEnv = require('./prod.env')

module.exports = merge(prodEnv, {
  NODE_ENV: '"development"',
  // BASE_URL: JSON.stringify('http://bi.dev.webinnovations.ru/api/')
  BASE_URL: JSON.stringify('http://xiaomibi.127.0.0.1.xip.io/api/')
})
