<form method="post" onsubmit="submitForm()" id="addform"
    class="d-none position-fixed top-50 start-50 translate-middle formbr--kai" style="background-color: #A2D8FF;">
    <div id="setFormContent"></div>
</form>
<script>
    let table = document.querySelector("#itemTable");
    function generateStockItems(data, thead, tbody) {
        let { item_id, cate_name, item_name, img_url, price, item_description, created_at } = data;
        thead.innerHTML = `
        <tr>
            <th><input type="checkbox" class="ms-3 mt-1" id="checkAllItem" onclick="toggle(this)" style="width:18px;height:18px;"></th>
            <th class="py-3">圖片</th>
            <th class="py-3">商品名稱</th>
            <th class="py-3">商品類別</th>
            <th class="py-3">商品描述</th>
            <th class="py-3">商品單價</th>
            <th class="py-3">上架日期</th>
            <th class="py-3">編輯</th>
        </tr>`
        tbody.innerHTML += `
        <tr class="text-center tritem--kai" id="itemrow-${item_id}">
            <td><input type="checkbox" class="ms-3 checkedItem--kai" onchange="depbox(event)"></td>
            <td class="py-3">
                <img src=${img_url} class="photofix--kai">
            </td>
            <td>${item_name}</td>
            <td>${cate_name}</td>
            <td style="width:20% ;text-align:start">${item_description}</td>
            <td>${price}</td>
            <td>${created_at}</td>
            <td class="fs-3">
                <i class="fa-solid fa-pencil pointer--kai text-success" onclick="edit(event)"></i>
                <i class="fa-solid fa-arrow-down ms-1 pointer--kai text-warning" id="takeOffItem takeOff-${item_id}" onclick="takeOff(event)"></i>
                <i class="fa-solid fa-delete-left pointer--kai ms-1 text-danger" id="remove-${item_id}" onclick="remove(this)"></i>
            </td>
        </tr>
    `
    }
    function generateStockItemsForReady(data, thead, tbody) {
        let { item_id, cate_name, item_name, img_url, price, item_description, created_at } = data;
        thead.innerHTML = `
        <tr>
            <th><input type="checkbox" class="ms-3 mt-1" id="checkAllItem" onclick="toggle(this)" style="width:18px;height:18px;"></th>
            <th class="py-3">圖片</th>
            <th class="py-3">商品名稱</th>
            <th class="py-3">商品類別</th>
            <th class="py-3">商品描述</th>
            <th class="py-3">商品單價</th>
            <th class="py-3">上架日期</th>
            <th class="py-3">編輯</th>
        </tr>`
        tbody.innerHTML += `
        <tr class="text-center tritem--kai" id="itemrow-${item_id}">
            <td><input type="checkbox" class="ms-3 checkedItem--kai" onchange="depbox(event)"></td>
            <td class="py-3 px-5">
                <img src=${img_url} class="photofix--kai">
            </td>
            <td>${item_name}</td>
            <td>${cate_name}</td>
            <td style="width:20% ;text-align:start">${item_description}</td>
            <td>${price}</td>
            <td>${created_at}</td>
            <td class="fs-3">
                <i class="fa-solid fa-pencil pointer--kai text-success" onclick="edit(event)"></i>
                <i class="fa-solid fa-arrow-up ms-1 pointer--kai text-warning" id="publishItem publish-${item_id}" onclick="publish(event)"></i>
                <i class="fa-solid fa-delete-left pointer--kai ms-1 text-danger" id="remove-${item_id}" onclick="remove(this)"></i>
            </td>
        </tr>
    `
    }
    let addNewItem = document.getElementById("addNewItem");
    let addform = document.getElementById("addform");
    let closeAdd = document.getElementById("closeAdd");
    let formContent = document.getElementById("setFormContent");
    let btngroup = (type) => {
        submitTrigger = type === "add" ? "addItemBtnTrigger()" : "updateItemBtnTrigger()";
        formContent.innerHTML += `<div class="addbtngroup--kai my-3">
                    <button type="button" class="addbtnstyle--kai p-2 rounded-3 pointer--kai" onclick=${submitTrigger}
                        style="background-color: #ffb74d">送出</button>
                    <button type="button" class="addbtnstyle--kai p-2 rounded-3 pointer--kai" onclick="closeForm()" style="background-color: #D2E3F7">取消</button>
                </div>`
    }
    let addItemBtnTrigger = () => {
        addform.action = "./controller/itemCreate.php";
        addform.submit();
    }
    let updateItemBtnTrigger = () => {
        addform.action = "./controller/itemUpdate.php";
        addform.submit();
    }
    let closeForm = () => {
        addform.classList.add("d-none");
    }
    addNewItem.addEventListener("click", () => {
        addform.classList.remove("d-none");
        formContent.innerHTML = "";
        formContent.innerHTML += `<div class="inputadd--kai pt-4">
            <div class="mx-auto fs-2 mb-3">
                <div>新增商品</div>
            </div>
            <div class="ms-3">
                <div class="innerinput mb-3">
                    <label for="itemName" style="color:#555555">商品名稱:</label>
                    <input type="text" name="itemName" id="itemName" style="background-color: #fff"
                        class="inputborder--kai">
                </div>
                <div class="innerinput mb-3">
                    <label for="cate" style="color:#555555">商品類別:</label>
                    <input type="text" name="cate" id="cate" style="background-color: #fff" class="inputborder--kai">
                </div>
                <div class="innerinput mb-3">
                    <label for="imgSrc" style="color:#555555">商品圖片:</label>
                    <input type="file" name="imgSrc" id="imgSrc">
                </div>
                <div class="innerinput mb-3">
                    <label for="price" style="color:#555555">商品價格:</label>
                    <input type="text" name="price" id="price" style="background-color: #fff"
                        class="inputborder--kai">
                </div>
                <div class="descrip--kai d-flex">
                    <label for="description" style="color:#555555">商品敘述:</label>
                    <textarea name="description" id="description" cols="30" rows="7" style="background-color: #fff"
                        class="inputborder--kai ms-2"></textarea>
                </div>
            </div>
        </div>`
        btngroup("add");
    });
    let edit = (event) => {
        let update_id = event.target.parentNode.parentNode.id.replace("itemrow-", "");
        addform.classList.remove("d-none");
        formContent.innerHTML = "";
        formContent.innerHTML += `<div class="inputadd--kai pt-4">
            <div class="mx-auto fs-2 mb-3">
                <div>編輯商品</div>
            </div>
            <div class="mx-3">
                <div class="innerinput mb-3">
                    <label for="itemName" style="color:#555555">商品名稱:</label>
                    <input type="text" name="itemName" id="itemName" style="background-color: #fff"
                        class="inputborder--kai">
                </div>
                <div class="innerinput mb-3">
                    <label for="cate" style="color:#555555">商品類別:</label>
                    <input type="text" name="cate" id="cate" style="background-color: #fff" class="inputborder--kai">
                </div>
                <div class="innerinput mb-3">
                    <label for="price" style="color:#555555">商品價格:</label>
                    <input type="text" name="price" id="price" style="background-color: #fff"
                        class="inputborder--kai">
                </div>
                <div class="descrip--kai d-flex">
                    <label for="description" style="color:#555555">商品敘述:</label>
                    <textarea name="description" id="description" cols="30" rows="7" style="background-color: #fff"
                        class="inputborder--kai ms-2"></textarea>
                </div>
                <input type="hidden" name="item_id" value="${update_id}">
            </div>
        </div>`
        btngroup("edit");
    }

</script>