
module.exports = {
proxyTable: {
    '/api': {
      target: 'https://his.hospbeluran.fastq.co',
      changeOrigin: true,
      pathRewrite: {
        '^/api': ''
      }
    }
}
}