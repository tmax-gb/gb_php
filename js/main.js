// класс выбора действия для товаров
class ProductAction {
    constructor () {
        this.productId = event.target.dataset['id']
        this._selectAction(event.target)
    }

    _selectAction(evt) { //выбор параметров для Ajax
        if (evt.classList.contains('buy-btn')) {
            this._selectAjax(evt, 'index.php?act=add&c=basket', {"productId": this.productId})
        } else if (evt.classList.contains('del-btn')) {
            this._selectAjax(evt, 'index.php?act=del&c=basket', {"productId": this.productId})
        } else if (evt.classList.contains('remove-btn')) {
            this._selectAjax(evt, 'index.php?act=del&c=basket', {"productId": this.productId, "prodRemove": true})
        }
    }

    _selectAjax(evt, url, data) {
        
        return $.ajax({
            url: url,
            method: "post",
            data: data,
            success: (response) => {
                let res = JSON.parse(response)
                $('#countProd').html(res.countProd)
                $('#q'+this.productId).html(res.quantity + ' шт.')
                $('#p'+this.productId).html(res.totalPrice + ' $')
                $('.basket-amount').html('Сумма заказа: ' + res.amountOrder['amount_order'] + ' $')
                $('.order-amount').html('Cумма вашего заказа составляет: ' + res.amountOrder['amount_order'] + ' $')
                if (evt.classList.contains('buy-btn')) {
                    $('#' + this.productId + ', #c' + this.productId).html("Товар добавлен")
                    $('#' + this.productId + ', #c' + this.productId).addClass('btn-success')
                    setTimeout (()=>{
                        $('#' + this.productId + ', #c' + this.productId).html("В корзину")
                        $('#' + this.productId + ', #c' + this.productId).removeClass('btn-success')
                        }, 1000);
                    $('.cart').addClass('btn-success')
                } else if (evt.classList.contains('del-btn') || evt.classList.contains('remove-btn')) {
                    if (res.quantity == null) {
                        $('#tr'+this.productId).html('')
                    }
                    if (res.countProd == 0) {
                        $('.container').html('<div class="alert alert-success mt-3" role="alert">Еще ничего не добавлено.</div>')
                        $('.cart').removeClass('btn-success')
                        $('.cart').addClass('btn-secondary')
                    }
                }
            }
        })
    }
}

//класс выбора действия для кнопок админки и пользовательского интерфейса
class BtnAction {
  constructor () {
    this.id = event.target.dataset['id']
    this.role = event.target.dataset['role']
    this.btn = event.target.dataset['btn']
    this.values = []
    this.prod = []
    this.check = false
    this._selectEvt(this.btn)

  }

  _selectEvt(btn) { //выбор параметров для Ajax 
    switch(btn) {
      case 'cart-btn':
        this._sendAjax("index.php?act=goodCart&c=admin", {"productId": this.id})
        break
      case 'add-btn':
        this.role = true
        this.values.push('https://placehold.it/350x200', $('.nameGood').val(), $('.priceGood').val(), $('.descGood').val())
        this.check = confirm('Добавить товар в каталог?')
        if (this.check) {
          this._sendAjax('index.php?act=addGood&c=admin', {"goodVal": this.values})
        }
        break
      case 'ch-btn':
        this.role = true
        this.values.push('https://placehold.it/350x200', $('#nameGood'+this.id).val(), $('#priceGood'+this.id).val(), $('#descGood'+this.id).val())
        this.check = confirm('Изменить информацию о товаре?')
        if (this.check) {
          this._sendAjax('index.php?act=changeGood&c=admin', {"goodVal": this.values, "productId": this.id})
        }
        break
      case 'rem-btn':
        this.isArch = event.target.dataset['ar']
        if (this.isArch) {
          this.check = confirm('Разместить товар в каталоге?')
          if (this.check) {
            this._sendAjax("index.php?act=returnGood&c=admin",  {"productId": this.id})
          }
        } else {
          this.check = confirm('Убрать товар из каталога в архив?')
          if (this.check) {
            this._sendAjax("index.php?act=removeGood&c=admin",  {"productId": this.id})
          }
        }
        break
      case 'del-btn':
        this.check = confirm('Удалить товар из базы?')
        if (this.check) {
          this._sendAjax("index.php?act=deleteGood&c=admin",  {"productId": this.id})
        }
        break
      case 'ch-stat-btn':
        this.check = confirm('Изменить статус заказа?')
        if (this.check) {
          let status = $('#order_status_'+this.id).val()
          this._sendAjax("index.php?act=changeStatus&c=admin",  {"orderId": this.id, "orderStatus": status})
        }
        break

    }
  }
  
  _sendAjax(url, data) { //отправка Ajax
     $.ajax({
      url: url,
      method: "post",
      data: data,
      success: (data) => {
        if (data) {
          this.prod = JSON.parse(data) //получение данных, если они есть
        }
        
      }
      }).done(() => {
        if (this.prod.length != 0) {
          this.temp = this._selectTemp(this.role, this.btn, this.prod) //выбор шаблона для размещения полученных данных
        }
        this._selectContainer(this.btn) //выбор контейнера для размещения шаблона
        
      })
  }

  _selectTemp(role, btn, good) { //выбор шаблона
    if (role) {
      switch (btn) {
        case 'cart-btn':
          return `<div class="card text-center">
      <div class="card-body d-flex">
        <div class="w-50">
          <img src="${ good.path }" class="card-img-top" width=500 height=500 alt="${ good.path }">
        </div>
        <div>
          <label for="file">Загузить изображения</label>
          <input class="filesGood"  type="file" id="file" multiple></input>
          <h5 class="card-title">Название товара <input type="text" id="nameGood${ good.id_good }" value="${ good.good_name }"></input></h5>
          <p class="card-text">Цена: <input type="text" id="priceGood${ good.id_good }" value="${ good.good_price }"></input> $</p>
          <p class="card-text">Краткое описание <textarea id="descGood${ good.id_good }">${ good.good_description }</textarea></p>
          <p class="card-text">Подробное описание <textarea class="card-text"></textarea></p>
        </div>
      </div>
      <div class="card-footer">
        <button id="ch_btn_${ good.id_good }" data-id="${ good.id_good }" data-btn="ch-btn" onclick="new BtnAction" class="btn btn-success">Изменить товар</button>
      </div>
    </div>`

        case 'add-btn':
          return `<div class="card m-4" style="width: 21rem; margin: 0 auto;">
          <img src="${ good.path }" class="card-img-top" alt="${ good.path }" data-id="${ good.id_good }">
          <div class="card-body" id="сart_body_${ good.id_good }" data-id="${ good.id_good }">
              <h5 class="card-title" data-id="${ good.id_good }">${ good.good_name }</h5>
              <p class="card-text" data-id="${ good.id_good }">Цена: ${ good.good_price } $</p>
              <footer class="blockquote-footer" data-id="${ good.id_good }">${ good.good_description }</footer>
          </div>
          <div class="d-flex">
            <button id="ch${ good.id_good }"  data-id="${ good.id_good }" data-role="true" data-btn="cart-btn" onclick="new BtnAction" class="btn btn-outline-success w-50" 
                data-toggle="modal" data-target=".bd-example-modal-xl">Изменить товар</button>
                
            <button id="rem${ good.id_good }" data-id="${ good.id_good }" data-btn="rem-btn" onclick="new BtnAction" class="btn btn-outline-danger w-50">Убрать в архив</button>
        </div>`

        case 'ch-btn':
          return `<h5 class="card-title">${ good.good_name }</h5>
          <p class="card-text">Цена: ${ good.good_price } $</p>
          <footer class="blockquote-footer">${ good.good_description }</footer>`
      }
      
    } else {
      return `<div class="card text-center">
      <div class="card-body d-flex">
      <div class="w-50">
      <img src="${ good.path }" class="card-img-top" width=500 height=500 alt="${ good.path }">
      </div>
      <div>
        <h5 class="card-title">${ good.good_name }</h5>
        <p class="card-text">Цена: ${ good.good_price } $</p>
        <p class="card-text">Подробное описание</p>
        </div>
        
      </div>
      <div class="card-footer">
        <button id="c${ good.id_good }" data-id="${ good.id_good }" onclick="new ProductAction" class="buy-btn btn btn-primary">В корзину</button>
      </div>
    </div>`
    }
  }
  
  _selectContainer(btn) { //выбор контейнера для размещения шаблона
    switch(btn) {
      case 'cart-btn':
        $('.modal-content').html(this.temp)
      break
      case 'add-btn':
          $('#catalog').append(this.temp)
          $('#add_good_btn').html("Товар добавлен")
          $('#add_good_btn').addClass('btn-warning')
          setTimeout (()=>{
            $('#add_good_btn').html("Добавить товар")
            $('#add_good_btn').removeClass('btn-warning')
          }, 1000)
      break
      case 'ch-btn':
          $('#сart_body_'+this.id).html(this.temp)
          $('#ch_btn_' + this.id).html("Товар изменен")
          $('#ch_btn_' + this.id).addClass('btn-warning')
          setTimeout (()=>{
            $('#ch_btn_' + this.id).html("Изменить товар")
            $('#ch_btn_' + this.id).removeClass('btn-warning')
          }, 1000)
      break
      case 'rem-btn':
        if (this.isArch) {
          $('#tr'+this.id).html('') 
        } else {
          $('#cart'+this.id+ ', #ch'+this.id+ ', #rem'+this.id).attr('disabled', 'disabled')
        }
      break
      case 'del-btn':
          $('#tr'+this.id).html('')
      break
      case 'ch-stat-btn':
          $('#stat_'+this.id).html(this.prod.order_status)
      break
    }
  }
  
}


//функция динамической подгрузки страницы
  var countGoods = 16;
  $('#more').click(function() { 
    var role = event.target.dataset['role'] 
    $.ajax({
        url: "index.php?act=loadMore",
        method: "post",
        data: {"countGoods": countGoods},
    
      success: function(data) {
          let catalog = JSON.parse(data);

          let res='';
          for (let good of catalog) {
            res += `<div class="card m-4" style="width: 21rem; margin: 0 auto;">
            <img src="${ good.path }" class="card-img-top" alt="${ good.path }" data-id="${ good.id_good }">
            <div class="card-body" id="сart_body_${ good.id_good }" data-id="${ good.id_good }">
                <h5 class="card-title" data-id="${ good.id_good }">${ good.good_name }</h5>
                <p class="card-text" data-id="${ good.id_good }">Цена: ${ good.good_price } $</p>
                <footer class="blockquote-footer" data-id="${ good.id_good }">${ good.good_description }</footer>
            </div>`
            if (role) {
              res += `<div class="d-flex">
              <button id="ch${ good.id_good }"  data-id="${ good.id_good }" data-role="true" data-btn="cart-btn" onclick="new BtnAction" class="btn btn-outline-success w-50" data-toggle="modal" data-target=".bd-example-modal-xl">Изменить товар</button>
                  
                    <button id="rem${ good.id_good }" data-id="${ good.id_good }" data-btn="rem-btn" onclick="new BtnAction" class="btn btn-outline-danger w-50">Убрать в архив</button>
                </div>
                </div>`
            } else {
              res += ` <div class="d-flex">
              <button data-id="${ good.id_good }" data-btn="cart-btn" onclick="new BtnAction" class="btn btn-secondary w-50" data-toggle="modal" data-target=".bd-example-modal-xl">Подробнее</button>
              <button id="${ good.id_good }" data-id="${ good.id_good }" onclick="new ProductAction" class="buy-btn btn btn-primary w-50">В корзину</button>
              </div>
              </div>`
            }        
          }
            $('#catalog').append(res) 
        if (catalog.length < 2) {
            $('#moreButton').html("Пока больше ничего нет");
        }
      }
    })
    countGoods+=16;
  });

//функция проверки заполненности полей для подтверждения заказа незарегестрированного пользователя
  $('.data-ord').keyup(() => {
    let value = [$('#oun').val(), $('#oup').val()];
  
    if (value[0].length != 0 && value[1].length != 0 ) {
      $('#btn-accept').removeAttr('disabled')
    } else {
      $('#btn-accept').attr('disabled', 'disabled')
    }
    
  })

