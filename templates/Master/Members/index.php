<!-- <?= $this->Krs->breadcrumb('Master', 'Member', '', $this->Url->build(['action' => 'add'])) ?> -->
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:;">Master</a></li>
            <li class="breadcrumb-item active">Member</li>
        </ol>
        <h1 class="page-header mb-0">Member</h1>
    </div>
    <div class="ms-auto">
        <a href="#" data-bs-toggle="dropdown" class="btn btn-outline-inverse btn-sm"><i class="fa fa-filter fa-lg"></i></a>
        <div class="dropdown-menu media-list dropdown-menu-end">
            <?= $this->Form->create(null, ['type' => 'get']) ?>
            <div class="dropdown-header">SEARCH DATA</div>
            <div class="dropdown-item media">
                <div class="row mb-3">
                    <label class="form-label col-form-label col-md-3">Kode</label>
                    <div class="col-md-9 mb-1">
                        <input type="text" class="form-control" name="code" value="<?= $this->request->getQuery('code'); ?>" placeholder="Kode..." />
                    </div>
                    <label class="form-label col-form-label col-md-3">Nama</label>
                    <div class="col-md-9 mb-1">
                        <input type="text" class="form-control" name="name" value="<?= $this->request->getQuery('name') ?>" placeholder="Nama member..." />
                    </div>
                    <label class="form-label col-form-label col-md-3">Telepon</label>
                    <div class="col-md-9 mb-1">
                        <input type="text" class="form-control" name="telp" value="<?= $this->request->getQuery('telp') ?>" placeholder="Telepon..." />
                    </div>
                    <label class="form-label col-form-label col-md-3">Npwp</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="npwp" value="<?= $this->request->getQuery('npwp') ?>" placeholder="Npwp..." />
                    </div>
                </div>
            </div>
            <div class="dropdown-footer">
                <button type="submit" class="btn btn-inverse"><i class="fas fa-search"></i>&nbsp;Cari</button>
            </div>
            <?= $this->Form->end() ?>
        </div>
        &nbsp;
        <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-inverse btn-sm">Add</i></a>
    </div>
</div>

<div class="mb-3 d-sm-flex fw-bold">
    <div class="mt-sm-0 mt-2"><a href="<?= $this->Url->build(['action' => 'excel']); ?>" class="text-dark text-decoration-none"><i class="fa fa-download fa-fw me-1 text-dark text-opacity-50"></i> Export</a></div>
    <div class="ms-sm-4 ps-sm-1 mt-sm-0 mt-2"><a href="#" class="text-dark text-decoration-none"><i class="fa fa-upload fa-fw me-1 text-dark text-opacity-50"></i> Import</a></div>
    <div class="ms-sm-4 ps-sm-1 mt-sm-0 mt-2 dropdown-toggle">
        <a href="#" data-bs-toggle="dropdown" class="text-dark text-decoration-none"><i class="fa fa-cog fa-fw me-1 text-dark text-opacity-50"></i> More Actions <b class="caret"></b></a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Delete</a>
        </div>
    </div>
</div>

<div class="card border-0">
    <ul class="nav nav-tabs nav-tabs-v2 px-3">
        <li class="nav-item me-2"><a href="#all" onclick="setActive('all')" class="nav-link px-2 active" id="all" data-toggle="portfilter" data-target="all">All</a></li>
        <li class="nav-item me-2"><a href="#active" onclick="setActive('active')" class="nav-link px-2" id="active" data-toggle="portfilter" data-target="Y">Active</a></li>
        <li class="nav-item me-2"><a href="#nonactive" onclick="setActive('nonactive')" class="nav-link px-2" id="nonactive" data-toggle="portfilter" data-target="N">Non-Active</a></li>
    </ul>
    <div class="tab-content p-3">
        <div class="tab-pane fade show active" id="all">
            <div class="table-responsive mb-3">
                <table class="table table-hover table-panel text-nowrap align-middle mb-0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>NPWP</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($members as $index => $data) {
                            $linkEdit = array('action' => 'edit', $data->id);
                            $linkDelete = array('action' => 'delete', $data->id);
                        ?>
                            <tr data-tag="<?= $data->is_active ?>">
                                <td class="w-10px align-middle">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="product1">
                                        <label class="form-check-label" for="product1"></label>
                                    </div>
                                </td>
                                <td><a href="#" class="fw-bold"><?= $data->code ?></a></td>
                                <td><?= $data->name ?></td>
                                <td><?= $data->telp ?></td>
                                <td><?= $data->npwp ?></td>
                                <td><span class="badge border <?= $data->is_active == "Y" ? "border-success text-success" : "border-secondary text-secondary"; ?> px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"><i class="fa fa-circle fs-9px fa-fw me-5px"></i><?= $data->is_active == "Y" ? "Active" : "Non-Active"; ?></span></td>
                                <td class="actions text-center">
                                    <?= $this->Krs->btn('edit', $linkEdit) ?>
                                    <?= $this->Krs->btn('delete', $linkDelete) ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?= $this->Krs->paginator($this->Paginator->counter('Show {{start}} page to {{end}} of {{count}} entries'), $this->Paginator->prev('«'), $this->Paginator->numbers(), $this->Paginator->next('»')) ?>
        </div>
    </div>
</div>

<script>
    ! function(d) {
        var c = "portfilter";
        var b = function(e) {
            this.$element = d(e);
            this.stuff = d("[data-tag]");
            this.target = this.$element.data("target") || ""
        };
        b.prototype.filter = function(g) {
            var e = [],
                f = this.target;
            this.stuff.fadeOut("fast").promise().done(function() {
                d(this).each(function() {
                    if (d(this).data("tag") == f || f == "all") {
                        e.push(this)
                    }
                });
                d(e).show()
            })
        };
        var a = d.fn[c];
        d.fn[c] = function(e) {
            return this.each(function() {
                var g = d(this),
                    f = g.data(c);
                if (!f) {
                    g.data(c, (f = new b(this)))
                }
                if (e == "filter") {
                    f.filter()
                }
            })
        };
        d.fn[c].defaults = {};
        d.fn[c].Constructor = b;
        d.fn[c].noConflict = function() {
            d.fn[c] = a;
            return this
        };
        d(document).on("click.portfilter.data-api", "[data-toggle^=portfilter]", function(f) {
            d(this).portfilter("filter")
        })
    }(window.jQuery);

    // function untuk set active sidebar
    function setActive(val) {
        switch (val) {
            case 'active':
                $('#active').addClass('active');
                $('#all').removeClass('active');
                $('#nonactive').removeClass('active');
                break;
            case 'nonactive':
                $('#nonactive').addClass('active');
                $('#all').removeClass('active');
                $('#active').removeClass('active');
                break;
            default:
                $('#all').addClass('active');
                $('#active').removeClass('active');
                $('#nonactive').removeClass('active');
                break;
        }
    }
</script>
