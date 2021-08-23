module.exports = {
  lintOnSave: false,
  runtimeCompiler: true,
  configureWebpack: {
    //Necessary to run npm link https://webpack.js.org/configuration/resolve/#resolve-symlinks
    resolve: {
       symlinks: false
    }
  },
  devServer: {
    proxy: {
      '/api': {
        target: 'https://his.hospbeluran.fastq.co/',
        changeOrigin: true
      }
    }
  }
}
