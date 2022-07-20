  // ハンバーガーメニューの動作
  const ham = document.querySelector('#js-hamburger');
  const nav = document.querySelector('#js-nav');

  ham.addEventListener('click', function () {
    ham.classList.toggle('active');
    nav.classList.toggle('active');
  });      
  
  // ハンバーガーメニュー押下後の画面でのクリック動作
    const navItem1 = document.querySelector('#nav-item1');
    const navItem2 = document.querySelector('#nav-item2');

    navItem1.addEventListener('click', function () {
      ham.classList.toggle('active');
      nav.classList.toggle('active');
    });      
    navItem2.addEventListener('click', function () {
      ham.classList.toggle('active');
      nav.classList.toggle('active');
    });    