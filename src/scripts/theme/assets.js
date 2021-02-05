
function importAll (r) {
  r.keys().forEach(r);
}

importAll(require.context('../../img/icons', false, /\.svg$/));
import '../../img/logo-theme-author.svg';
import '../../img/logo.svg';
