window.submit = function submit() {
    axios.post('/confirmation/create').then(response => {
        location.href = response.data;
    }).catch(error => {
    });
}

// ブラウザバック時にリロードする
window.addEventListener('pageshow',()=>{
  if(window.performance.navigation.type==2) location.reload();
});