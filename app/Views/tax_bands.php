<?php require 'layout_header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">Tax Configuration</h1>
</div>

<div class="alert mb-4" style="background-color: var(--card-bg); border-radius: var(--border-radius-lg); padding: 20px; border: none; color: var(--text-dark);">
    <span class="material-symbols-rounded" style="color: var(--text-muted); margin-right: 10px;">info</span>
    Enter the width of the band in the "Limit Amount" column. Leave the last band's limit empty so it calculates the tax on the remaining "exceeding" income.
</div>

<div class="card" style="max-width: 900px;">
    <div class="card-header text-center" style="font-size: 1rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; padding-top: 30px;">
        GHANA REVENUE AUTHORITY BRACKETS
    </div>
    <div class="card-body px-5 pb-5">
        <form action="index.php?page=update_taxes" method="POST">
            <div class="table-responsive inner-card mb-4">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th style="border-bottom: none;">Band Level</th>
                            <th style="border-bottom: none;">Limit Amount (Width)</th>
                            <th style="border-bottom: none;">Tax Rate (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($taxBands as $index => $band): ?>
                        <tr style="border-bottom: none;">
                            <td class="align-middle fw-bold text-dark border-0">
                                Band <?= $index + 1 ?>
                                <?php if ($index === count($taxBands) - 1): ?>
                                    <span style="background-color: #FDE8E8; color: #7F1D1D; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; margin-left: 10px;">Max</span>
                                <?php endif; ?>
                            </td>
                            <td class="border-0">
                                <input type="number" step="0.01" 
                                       name="limits[<?= $band['id'] ?>]" 
                                       class="form-control" 
                                       style="background-color: var(--bg-color); box-shadow: none;"
                                       value="<?= htmlspecialchars($band['limit_amount'] ?? '') ?>" 
                                       placeholder="Exceeding (Leave blank)">
                            </td>
                            <td class="border-0">
                                <input type="number" step="0.01" 
                                       name="rates[<?= $band['id'] ?>]" 
                                       class="form-control" 
                                       style="background-color: var(--bg-color); box-shadow: none;"
                                       value="<?= htmlspecialchars($band['rate_percentage']) ?>" required>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary py-3 px-5 d-inline-flex justify-content-center align-items-center">
                    Save Tax Configuration <span class="material-symbols-rounded ms-2" style="font-size: 18px;">arrow_forward</span>
                </button>
            </div>
        </form>
    </div>
</div>

<?php require 'layout_footer.php'; ?>
