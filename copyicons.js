/**
  Bootstrap icons for PmWiki
  Written by (c) Petko Yotov 2023-2024   www.pmwiki.org/Petko
  License: MIT, see file LICENSE
  
  This enables click-to-copy of icons from (:biconlist:) listings.

*/

document.addEventListener('click', function(e){
  var item = e.target.closest('ul.biconlist > li');
  if(!item) return;
  var text = item.textContent.trim();
  
  navigator.clipboard.writeText(text);
  item.classList.add('copied');
  setTimeout(function(){item.classList.remove('copied');}, 3000);
});
