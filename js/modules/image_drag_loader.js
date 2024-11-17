
class ImageDragHandler {
    constructor(dom_element, hover_class) {
        this.dragover = false;
        this.hover_class = hover_class
        this.dom_element = dom_element;
        this.target_id = dom_element.id;
        this.handle_load();
    }

    handle_load() {
        // Обработка попадания файла на страницу
        this.dom_element.addEventListener('dragenter', (e) => this.handle_dragenter(e));
        this.dom_element.addEventListener('dragover', (e) => this.handle_dragover(e));
        this.dom_element.addEventListener('dragleave', (e) => this.handle_dragover(e));
    
        // Обрабатываем дроп картинки
        document.body.addEventListener('drop', (e) => this.handle_drop(e));
    }


    handle_dragenter(e) {
    
        console.log(`${this.target_id}: Drag enter event`);
        this.dom_element.classList.toggle(this.hover_class);
    
        this.dragover = true;
        prevent_default_action(e);
    }
    
    handle_dragleave(e) {
        
        console.log(`${this.target_id}: Drag leave event`);
        this.dom_element.classList.toggle(this.hover_class);
    
        this.dragover = false;
        prevent_default_action(e);
    }
    
    handle_dragover(e) {
        prevent_default_action(e);
        console.log(`${this.target_id}: Drag over event`)
    
        if ((e.type == 'dragover' || e.type == 'onmouseover') && this.dragover) {
            console.log (`${this.target_id}: Dragover event`);
            this.dom_element.classList.add(this.hover_class);
        }else {
            console.log (`${this.target_id}: Drag leave event`);
            this.dom_element.classList.remove(this.hover_class);
    
        }
    }
    
    handle_drop (e) {
        prevent_default_action(e);
    
        if (e.target.id === this.target_id) {
            handle_data_transfer(e, (responce) => {
                if (responce.status != 0)
                    alert(responce.message);
                else {
                    this.dom_element.style.backgroundImage = `url(${responce.avatar_src})`;
                }
                this.dom_element.classList.remove(this.hover_class);
            }, '/server/action/user_entry_control.php');
        }
    }
    
    
    
}

