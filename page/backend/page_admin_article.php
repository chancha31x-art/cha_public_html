<style>
    .admin-article-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 18px 20px;
        position: relative;
        overflow: hidden;
    }
    .admin-article-header::after {
        content: '';
        position: absolute;
        top: -50%; right: -50%;
        width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    }
    .btn-add-article {
        background: white; color: #667eea; border: none;
        border-radius: 12px; font-weight: 700; padding: 8px 20px;
        transition: all 0.2s ease;
    }
    .btn-add-article:hover { background: #f0f0f0; color: #667eea; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
    .admin-table th {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        font-weight: 700; color: #1e293b; padding: 14px 16px; border: none;
    }
    .admin-table td { padding: 14px 16px; vertical-align: middle; border-color: rgba(226,232,240,0.5); }
    .admin-table tr:hover td { background: rgba(102,126,234,0.04); }
    .btn-edit-art {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white; border: none; border-radius: 10px; font-weight: 600;
        padding: 5px 14px; font-size: 0.82rem; transition: all 0.2s ease;
    }
    .btn-edit-art:hover { box-shadow: 0 4px 10px rgba(245,158,11,0.4); color: white; }
    .btn-del-art {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white; border: none; border-radius: 10px; font-weight: 600;
        padding: 5px 14px; font-size: 0.82rem; transition: all 0.2s ease;
    }
    .btn-del-art:hover { box-shadow: 0 4px 10px rgba(239,68,68,0.4); color: white; }
    .btn-preview-art {
        background: linear-gradient(135deg, #06b6d4 0%, #0284c7 100%);
        color: white; border: none; border-radius: 10px; font-weight: 600;
        padding: 5px 14px; font-size: 0.82rem; transition: all 0.2s ease;
    }
    .btn-preview-art:hover { box-shadow: 0 4px 10px rgba(6,182,212,0.4); color: white; }
    .modal-content { border-radius: 20px !important; overflow: visible; border: none !important; }
    .modal-dialog-scrollable .modal-content { overflow: hidden; }
    .modal-dialog-scrollable .modal-body { overflow-y: auto; max-height: calc(100vh - 200px); }
    /* Summernote fix inside scrollable modal */
    .note-editor { max-height: 300px; }
    .note-editable { max-height: 220px; overflow-y: auto !important; }
    .modal-header-grad {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white; border: none; padding: 18px 20px;
    }
    .form-control, .form-select {
        border-radius: 12px !important;
        border: 2px solid #e2e8f0 !important;
        padding: 10px 14px !important;
        transition: all 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #667eea !important;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.15) !important;
    }
    .btn-save-art {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white; border: none; border-radius: 12px; font-weight: 600;
        padding: 10px 25px; transition: all 0.2s ease;
    }
    .btn-save-art:hover { box-shadow: 0 6px 15px rgba(102,126,234,0.4); color: white; }
    .tag-badge {
        display: inline-block;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white; padding: 2px 8px; border-radius: 20px;
        font-size: 0.72rem; margin: 2px; font-weight: 600;
    }
    .section-label {
        font-weight: 700; color: #374151; font-size: 0.9rem;
        margin-bottom: 6px; display: flex; align-items: center; gap: 6px;
    }
    .json-textarea {
        font-family: 'Courier New', monospace !important;
        font-size: 0.82rem !important;
        background: #1e293b !important;
        color: #e2e8f0 !important;
        border-color: #334155 !important;
        border-radius: 12px !important;
        padding: 12px !important;
    }
    .json-textarea:focus {
        border-color: #667eea !important;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.2) !important;
        background: #0f172a !important;
    }
    .json-textarea::placeholder { color: #64748b !important; }
</style>

<?php
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action == 'add' || $action == 'edit') {
    $title       = $connect->real_escape_string($_POST['title']);
    $slug        = $connect->real_escape_string(preg_replace('/\s+/', '-', strtolower($_POST['slug'])));
    $content     = $connect->real_escape_string($_POST['content']);
    $img         = $connect->real_escape_string($_POST['img']);
    $category    = $connect->real_escape_string($_POST['category']);
    $author      = $connect->real_escape_string($_POST['author']);
    $status      = (int)$_POST['status'];
    $tags        = $connect->real_escape_string(trim($_POST['tags']));
    $json_schema = $connect->real_escape_string(trim($_POST['json_schema']));

    if ($action == 'add') {
        $meta_title       = $connect->real_escape_string(trim($_POST['meta_title']));
        $meta_description = $connect->real_escape_string(trim($_POST['meta_description']));
        $connect->query("INSERT INTO pp_article (title, slug, content, img, category, author, status, tags, json_schema, meta_title, meta_description)
                         VALUES ('$title','$slug','$content','$img','$category','$author',$status,'$tags','$json_schema','$meta_title','$meta_description')");
    } else {
        $edit_id = (int)$_POST['edit_id'];
        $meta_title       = $connect->real_escape_string(trim($_POST['meta_title']));
        $meta_description = $connect->real_escape_string(trim($_POST['meta_description']));
        $connect->query("UPDATE pp_article SET title='$title', slug='$slug', content='$content', img='$img',
                         category='$category', author='$author', status=$status, tags='$tags', json_schema='$json_schema',
                         meta_title='$meta_title', meta_description='$meta_description'
                         WHERE id=$edit_id");
    }
}

if ($action == 'delete') {
    $del_id = (int)$_POST['del_id'];
    $connect->query("DELETE FROM pp_article WHERE id=$del_id");
}

if ($action == 'toggle_status') {
    $tog_id = (int)$_POST['tog_id'];
    $connect->query("UPDATE pp_article SET status = IF(status=1,0,1) WHERE id=$tog_id");
}

$result_all   = $connect->query("SELECT * FROM pp_article ORDER BY created_at DESC");
$all_articles = $result_all ? $result_all->fetch_all(MYSQLI_ASSOC) : [];

function statusBadge($s) {
    if ($s == 1) return '<span style="background:#10b981;color:white;padding:3px 10px;border-radius:12px;font-size:0.78rem;font-weight:600;">✅ เผยแพร่</span>';
    if ($s == 2) return '<span style="background:#f59e0b;color:white;padding:3px 10px;border-radius:12px;font-size:0.78rem;font-weight:600;">📝 ดราฟ</span>';
    return '<span style="background:#94a3b8;color:white;padding:3px 10px;border-radius:12px;font-size:0.78rem;font-weight:600;">🚫 ซ่อน</span>';
}
?>

<div class="col-md-12 col-sm-12 col-12 mt-4 mb-4">
    <div class="card shadow-lg" style="background:rgba(255,255,255,0.97);border:none;border-radius:20px;overflow:hidden;">

        <div class="admin-article-header">
            <div style="position:relative;z-index:2;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
                <h5 class="mb-0" style="font-weight:700;display:flex;align-items:center;gap:10px;">
                    <i class='bx bx-news'></i> จัดการบทความ
                    <span style="font-size:13px;opacity:0.8;font-weight:400;">(<?=count($all_articles)?> บทความ)</span>
                </h5>
                <button class="btn btn-add-article" data-bs-toggle="modal" data-bs-target="#addArticleModal">
                    <i class="fas fa-plus"></i> เพิ่มบทความ
                </button>
            </div>
        </div>

        <div class="card-body p-3">
            <div class="table-responsive" style="border-radius:12px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,0.08);">
                <table class="table table-hover admin-table mb-0">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th>ชื่อบทความ</th>
                            <th>หมวดหมู่ / แท็ก</th>
                            <th>ผู้เขียน</th>
                            <th>วิว</th>
                            <th>สถานะ</th>
                            <th>วันที่</th>
                            <th width="160">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($all_articles) > 0): ?>
                            <?php foreach ($all_articles as $art): ?>
                                <tr>
                                    <td><?=$art['id']?></td>
                                    <td>
                                        <strong style="color:#1a202c;"><?=htmlspecialchars($art['title'])?></strong>
                                        <?php if (!empty($art['json_schema'])): ?>
                                            <br><small style="color:#6366f1;"><i class="fas fa-code"></i> มี JSON Schema</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span style="background:linear-gradient(135deg,#667eea,#764ba2);color:white;padding:3px 10px;border-radius:12px;font-size:0.78rem;font-weight:600;">
                                            <?=htmlspecialchars($art['category'])?>
                                        </span>
                                        <?php if (!empty($art['tags'])): ?>
                                            <div style="margin-top:4px;">
                                                <?php foreach(explode(',', $art['tags']) as $tag): ?>
                                                    <?php if(trim($tag)): ?>
                                                        <span class="tag-badge">#<?=htmlspecialchars(trim($tag))?></span>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?=htmlspecialchars($art['author'])?></td>
                                    <td><i class="fas fa-eye" style="color:#10b981;"></i> <?=number_format($art['views'])?></td>
                                    <td><?=statusBadge($art['status'])?></td>
                                    <td style="font-size:0.82rem;color:#64748b;"><?=date('d/m/Y', strtotime($art['created_at']))?></td>
                                    <td>
                                        <a href="/article/<?=$art['slug']?>" target="_blank" class="btn btn-preview-art me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-edit-art me-1"
                                            onclick="openEditModal(<?=htmlspecialchars(json_encode($art))?>)">
                                            <i class="fas fa-edit"></i> แก้ไข
                                        </button>
                                        <form method="POST" style="display:inline;" onsubmit="return confirm('ลบบทความนี้?')">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="del_id" value="<?=$art['id']?>">
                                            <button type="submit" class="btn btn-del-art"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center p-5" style="color:#94a3b8;">
                                    <i class='bx bx-news' style="font-size:2.5rem;display:block;margin-bottom:10px;opacity:0.4;"></i>
                                    ยังไม่มีบทความ
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ========== MODAL รวม (ใช้ทั้ง เพิ่ม และ แก้ไข) ========== -->
<?php foreach ([['add','เพิ่มบทความใหม่','fas fa-plus','addArticleModal'], ['edit','แก้ไขบทความ','fas fa-edit','editArticleModal']] as [$mode, $title_modal, $icon, $modalId]): ?>
<div class="modal fade" id="<?=$modalId?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header modal-header-grad">
                <h5 class="modal-title" style="font-weight:700;"><i class="<?=$icon?>"></i> <?=$title_modal?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="<?=$mode?>">
                <?php if($mode=='edit'): ?><input type="hidden" name="edit_id" id="edit_id"><?php endif; ?>
                <div class="modal-body p-4">

                    <!-- ชื่อบทความ -->
                    <div class="mb-3">
                        <div class="section-label"><i class="fas fa-heading" style="color:#667eea;"></i> ชื่อบทความ <span class="text-danger">*</span></div>
                        <input type="text" name="title" id="<?=$mode?>_title" class="form-control" required placeholder="ชื่อบทความ..."
                               <?php if($mode=='add'): ?>oninput="autoSlug(this.value,'add_slug')"<?php endif; ?>>
                    </div>

                    <!-- Slug -->
                    <div class="mb-3">
                        <div class="section-label"><i class="fas fa-link" style="color:#667eea;"></i> Slug (URL)</div>
                        <input type="text" name="slug" id="<?=$mode?>_slug" class="form-control" placeholder="my-article-url">
                    </div>

                    <!-- หมวดหมู่ + ผู้เขียน -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="section-label"><i class="fas fa-folder" style="color:#f093fb;"></i> หมวดหมู่</div>
                            <input type="text" name="category" id="<?=$mode?>_category" class="form-control" placeholder="Netflix, Spotify..." <?php if($mode=='add'): ?>value="ทั่วไป"<?php endif; ?>>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="section-label"><i class="fas fa-user" style="color:#f093fb;"></i> ผู้เขียน</div>
                            <input type="text" name="author" id="<?=$mode?>_author" class="form-control" placeholder="ชื่อผู้เขียน" <?php if($mode=='add'): ?>value="Admin"<?php endif; ?>>
                        </div>
                    </div>

                    <!-- แท็ก -->
                    <div class="mb-3">
                        <div class="section-label"><i class="fas fa-tags" style="color:#10b981;"></i> แท็ก</div>
                        <input type="text" name="tags" id="<?=$mode?>_tags" class="form-control"
                               placeholder="netflix, streaming, ราคาถูก (คั่นด้วยจุลภาค)">
                        <small class="text-muted">คั่นแต่ละแท็กด้วย , เช่น netflix, streaming, ราคาถูก</small>
                    </div>

                    <!-- URL รูปภาพ -->
                    <div class="mb-3">
                        <div class="section-label"><i class="fas fa-image" style="color:#f59e0b;"></i> URL รูปภาพหน้าปก</div>
                        <input type="text" name="img" id="<?=$mode?>_img" class="form-control" placeholder="https://...">
                    </div>

                    <!-- เนื้อหา -->
                    <div class="mb-3">
                        <div class="section-label"><i class="fas fa-align-left" style="color:#667eea;"></i> เนื้อหา <span class="text-danger">*</span></div>
                        <textarea name="content" id="<?=$mode?>_content" class="form-control summernote" rows="6"></textarea>
                    </div>

                    <!-- SEO Meta -->
                    <div class="mb-3" style="background:#f0fdf4;border-radius:14px;padding:16px;border:1.5px solid #bbf7d0;">
                        <div class="section-label mb-3">
                            <i class="fas fa-search" style="color:#059669;"></i> SEO Meta Tags
                            <span style="font-size:0.75rem;background:#dcfce7;color:#059669;padding:2px 8px;border-radius:8px;font-weight:600;">SEO</span>
                        </div>
                        <div class="mb-2">
                            <label class="section-label" style="font-size:0.82rem;color:#065f46;">Meta Title <small style="color:#94a3b8;font-weight:400;">(max 60 ตัวอักษร)</small></label>
                            <input type="text" name="meta_title" id="<?=$mode?>_meta_title" class="form-control"
                                   placeholder="ชื่อที่แสดงใน Google (ถ้าว่างจะใช้ชื่อบทความ)"
                                   maxlength="60" oninput="updateMetaCount(this,'<?=$mode?>_meta_title_count')">
                            <small><span id="<?=$mode?>_meta_title_count">0</span>/60 ตัวอักษร</small>
                        </div>
                        <div class="mb-0">
                            <label class="section-label" style="font-size:0.82rem;color:#065f46;">Meta Description <small style="color:#94a3b8;font-weight:400;">(max 160 ตัวอักษร)</small></label>
                            <textarea name="meta_description" id="<?=$mode?>_meta_description" class="form-control" rows="3"
                                      placeholder="คำอธิบายที่แสดงใน Google (ถ้าว่างจะใช้ต้นเนื้อหา)"
                                      maxlength="160" oninput="updateMetaCount(this,'<?=$mode?>_meta_desc_count')"></textarea>
                            <small><span id="<?=$mode?>_meta_desc_count">0</span>/160 ตัวอักษร</small>
                        </div>
                    </div>

                    <!-- JSON Schema -->
                    <div class="mb-3">
                        <div class="section-label">
                            <i class="fas fa-code" style="color:#6366f1;"></i> JSON Schema
                            <span style="font-size:0.75rem;background:#ede9fe;color:#6366f1;padding:2px 8px;border-radius:8px;font-weight:600;">SEO</span>
                        </div>
                        <textarea name="json_schema" id="<?=$mode?>_json_schema" class="form-control json-textarea" rows="7"
                                  placeholder='{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "ชื่อบทความ",
  "author": {"@type": "Person", "name": "Admin"},
  "datePublished": "2024-01-01"
}'></textarea>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> JSON-LD Schema สำหรับ SEO — ถ้าไม่มีให้เว้นว่างไว้</small>
                    </div>

                    <!-- สถานะ -->
                    <div class="mb-3">
                        <div class="section-label"><i class="fas fa-toggle-on" style="color:#667eea;"></i> สถานะ</div>
                        <select name="status" id="<?=$mode?>_status" class="form-select">
                            <option value="1">✅ เผยแพร่</option>
                            <option value="2" <?php if($mode=='add'): ?>selected<?php endif; ?>>📝 ดราฟ</option>
                            <option value="0">🚫 ซ่อน</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer" style="background:#f8fafc;border-top:1px solid rgba(226,232,240,0.6);">
                    <button type="submit" class="btn btn-save-art"><i class="fas fa-save"></i> บันทึก<?=$mode=='edit'?'การแก้ไข':''?></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius:12px;">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<script>
function updateMetaCount(el, countId) {
    var c = document.getElementById(countId);
    if (c) c.textContent = el.value.length;
}

function autoSlug(val, targetId) {
    var slug = val.toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-');
    document.getElementById(targetId).value = slug;
}

function openEditModal(art) {
    document.getElementById('edit_id').value            = art.id;
    document.getElementById('edit_title').value         = art.title;
    document.getElementById('edit_slug').value          = art.slug;
    document.getElementById('edit_category').value      = art.category;
    document.getElementById('edit_author').value        = art.author;
    document.getElementById('edit_img').value           = art.img || '';
    document.getElementById('edit_tags').value          = art.tags || '';
    document.getElementById('edit_json_schema').value   = art.json_schema || '';
    document.getElementById('edit_meta_title').value       = art.meta_title || '';
    document.getElementById('edit_meta_description').value = art.meta_description || '';
    updateMetaCount(document.getElementById('edit_meta_title'), 'edit_meta_title_count');
    updateMetaCount(document.getElementById('edit_meta_description'), 'edit_meta_desc_count');
    document.getElementById('edit_status').value        = art.status;

    // Summernote
    if ($('#edit_content').next('.note-editor').length) {
        $('#edit_content').summernote('code', art.content);
    } else {
        document.getElementById('edit_content').value = art.content;
    }

    new bootstrap.Modal(document.getElementById('editArticleModal')).show();
}
</script>