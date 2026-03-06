<div class="mb-3">
    <label class="form-label fw-bold">ชื่อบทความ <span class="text-danger">*</span></label>
    <input type="text" name="title" class="form-control" required placeholder="ชื่อบทความ..." 
           oninput="autoSlug(this.value)">
</div>
<div class="mb-3">
    <label class="form-label fw-bold">Slug (URL) <span class="text-danger">*</span></label>
    <input type="text" name="slug" id="slug_input" class="form-control" required placeholder="my-article-url">
    <small class="text-muted">ใช้ตัวอักษร a-z, 0-9 และ - เท่านั้น</small>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">หมวดหมู่</label>
        <input type="text" name="category" class="form-control" placeholder="Netflix, Spotify, ทั่วไป..." value="ทั่วไป">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">ผู้เขียน</label>
        <input type="text" name="author" class="form-control" placeholder="ชื่อผู้เขียน" value="Admin">
    </div>
</div>
<div class="mb-3">
    <label class="form-label fw-bold">URL รูปภาพหน้าปก</label>
    <input type="text" name="img" class="form-control" placeholder="https://example.com/image.jpg (ถ้าไม่มีให้เว้นว่าง)">
</div>
<div class="mb-3">
    <label class="form-label fw-bold">เนื้อหา <span class="text-danger">*</span></label>
    <textarea name="content" class="form-control summernote" rows="6" placeholder="เนื้อหาบทความ..."></textarea>
</div>
<div class="mb-3">
    <label class="form-label fw-bold">สถานะ</label>
    <select name="status" class="form-select">
        <option value="1">✅ เผยแพร่</option>
        <option value="0">🚫 ซ่อน (ฉบับร่าง)</option>
    </select>
</div>

<script>
function autoSlug(val) {
    var slug = val.toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-');
    document.getElementById('slug_input').value = slug;
}
</script>
