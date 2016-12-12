<div class="item-filters">
    <select name="sort" id="filters">
        <option value="dflt" <?php if ($this->gets['sort'] == 'dflt') echo 'selected' ?>>Default</option>
        <option value="ascp" <?php if ($this->gets['sort'] == 'ascp') echo 'selected' ?>>Price: ascending</option>
        <option value="descp" <?php if ($this->gets['sort'] == 'descp') echo 'selected' ?>>Price: descending</option>
        <option value="asca" <?php if ($this->gets['sort'] == 'asca') echo 'selected' ?>>Name: A-Z</option>
        <option value="desca" <?php if ($this->gets['sort'] == 'desca') echo 'selected' ?>>Name: Z-A <i class="fa fa-long-arrow-down" aria-hidden="true"></i></option>
        <option value="rate" <?php if ($this->gets['sort'] == 'rate') echo 'selected' ?>>Rating</option>
        <option value="pop" <?php if ($this->gets['sort'] == 'pop') echo 'selected' ?>>Popularity</option>
    </select>
    <p>Sort</p>
</div>