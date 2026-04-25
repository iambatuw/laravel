<?php $__env->startSection('title', 'Nöbet Çizelgeleri | Nöbet Kontrol'); ?>
<?php $__env->startSection('page-title', 'Tüm Nöbet Çizelgeleri'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row mb-5 align-items-center">
        <div class="col-md-7">
            <p class="text-muted mb-0"><i class="bi bi-info-circle-fill me-2 text-primary"></i>Geçmiş ve gelecek tüm nöbet programlarını buradan yönetebilirsiniz.</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            <a href="<?php echo e(route('schedules.create')); ?>" class="btn btn-primary px-4 py-2 shadow-sm fw-bold">
                 <i class="bi bi-plus-lg me-2"></i> Yeni Çizelge Oluştur
            </a>
        </div>
    </div>

    <div class="card border-0">
        <div class="card-body p-0">
            <?php if($schedules->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-5">Tarih</th>
                                <th>Başlık / Açıklama</th>
                                <th class="text-center">Atamalar</th>
                                <th>Oluşturan</th>
                                <th class="text-center">Durum</th>
                                <th class="text-end pe-5">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $isToday = $schedule->date->isToday();
                                    $dateBg = $isToday ? 'var(--primary-gradient)' : 'rgba(255,255,255,0.05)';
                                ?>
                                <tr>
                                    <td class="ps-5">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="text-center p-2 rounded-3" style="width: 46px; background: <?php echo e($dateBg); ?>; border: 1px solid rgba(255,255,255,0.1);">
                                                <div class="fw-bold" style="font-size: 15px; color: #fff;"><?php echo e($schedule->date->format('d')); ?></div>
                                                <div class="text-uppercase" style="font-size: 9px; color: rgba(255,255,255,0.7); font-weight: 700;"><?php echo e($schedule->date->locale('tr')->shortMonthName); ?></div>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-light"><?php echo e($schedule->day_of_week); ?></div>
                                                <div class="text-muted small"><?php echo e($schedule->date->format('d.m.Y')); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-light fw-bold mb-1"><?php echo e($schedule->title); ?></div>
                                        <div class="text-muted small opacity-75">Haftalık rutin nöbet çizelgesi</div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-dark border border-secondary" style="width: 32px; height: 32px; font-size: 12px; font-weight: 800; color: rgb(129, 140, 248);">
                                            <?php echo e($schedule->assignments_count); ?>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="p-1 rounded bg-secondary-subtle" style="font-size: 10px; font-weight: 700;">ADMIN</div>
                                            <div class="text-muted small"><?php echo e($schedule->creator->name ?? 'Sistem'); ?></div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                            $sCls = $schedule->status === 'published' ? 'bg-success' : ($schedule->status === 'draft' ? 'bg-warning text-dark' : 'bg-info');
                                            $sLabel = $schedule->status === 'draft' ? 'TASLAK' : ($schedule->status === 'published' ? 'YAYINDA' : 'TAMAMLANDI');
                                        ?>
                                        <span class="badge <?php echo e($sCls); ?> shadow-sm">
                                            <?php echo e($sLabel); ?>

                                        </span>
                                    </td>
                                    <td class="text-end pe-5">
                                        <div class="btn-group gap-2">
                                            <a href="<?php echo e(route('schedules.show', $schedule)); ?>" class="btn btn-dark btn-sm rounded-3 border-0" style="background: rgba(255,255,255,0.05);" title="Detay">
                                                <i class="bi bi-eye-fill text-info"></i>
                                            </a>
                                            <a href="<?php echo e(route('schedules.edit', $schedule)); ?>" class="btn btn-dark btn-sm rounded-3 border-0" style="background: rgba(255,255,255,0.05);" title="Düzenle">
                                                <i class="bi bi-pencil-fill text-warning"></i>
                                            </a>
                                            <button type="button" class="btn btn-dark btn-sm rounded-3 border-0" style="background: rgba(255,255,255,0.05);" onclick="confirmDelete('del-sch-<?php echo e($schedule->id); ?>', '<?php echo e($schedule->date->format('d.m.Y')); ?> Çizelgesi')" title="Sil">
                                                <i class="bi bi-trash3-fill text-danger"></i>
                                            </button>
                                            <form id="del-sch-<?php echo e($schedule->id); ?>" action="<?php echo e(route('schedules.destroy', $schedule)); ?>" method="POST" class="d-none">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <?php if($schedules->hasPages()): ?>
                    <div class="p-4 border-top border-light border-opacity-10 d-flex justify-content-center">
                        <?php echo e($schedules->links()); ?>

                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-5">
                    <div class="text-muted mb-4 pt-4">
                        <i class="bi bi-calendar-x" style="font-size: 100px; opacity: 0.1;"></i>
                    </div>
                    <h4 class="text-light fw-bold">Henüz Çizelge Oluşturulmamış</h4>
                    <p class="text-muted mb-4">Sisteme ilk nöbet çizelgesini ekleyerek başlayabilirsiniz.</p>
                    <a href="<?php echo e(route('schedules.create')); ?>" class="btn btn-primary px-5 py-3 fw-bold rounded-3">
                        <i class="bi bi-plus-lg me-2"></i> İlk Çizelgeyi Başlat
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\batuh\OneDrive\Masaüstü\laravel\resources\views/schedules/index.blade.php ENDPATH**/ ?>