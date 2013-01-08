<?php
use \core\SGA;
use \core\util\DateUtil;
use \core\contrib\Highcharts;
use \core\contrib\Serie;
?>
<div>
    <div id="tabs">
        <ul>
            <li><a href="#tab-hoje"><?php SGA::out(_('Hoje')) ?></a></li>
            <li><a href="#tab-graficos"><?php SGA::out(_('Gráficos')) ?></a></li>
            <li><a href="#tab-relatorios"><?php SGA::out(_('Relatórios')) ?></a></li>
        </ul>
        <div id="tab-hoje">
            <h2 class="chart-title"><?php SGA::out(sprintf(_('Atendimentos realizados em %s'), DateUtil::now(_('d/m/Y')))) ?></h2>
            <?php 
            foreach ($unidades as $unidade) {
                $id = $unidade->getId();
                $script = '';
                if (isset($atendimentosStatus[$id])) {
                    $atendimento = $atendimentosStatus[$id];
                    $chart = new Highcharts('atendimentos-status-' . $id, _('Atendimentos por situação'));
                    $chart->setType('pie');
                    $data = array();
                    $data[] = array(_('Encerrado'), (int) $atendimento['encerrado']);
                    if ($atendimento['nao_compareceu'] > 0) {
                        $data[] = array(_('Não compareceu'), (int) $atendimento['nao_compareceu']);
                    }
                    if ($atendimento['senha_cancelada'] > 0) {
                        $data[] = array(_('Senha cancelada'), (int) $atendimento['senha_cancelada']);
                    }
                    if ($atendimento['erro_triagem'] > 0) {
                        $data[] = array(_('Erro triagem'), (int) $atendimento['erro_triagem']);
                    }
                    $chart->addSerie(new Serie('Atendimentos', $data));
                    $script .= '<div id="' . $chart->getId() .'" class="chart pie atendimentos status"></div>';
                    $script .= $chart->toString();
                }
                if (isset($atendimentosServico[$id])) {
                    $atendimentos = $atendimentosServico[$id];
                    $chart = new Highcharts('atendimentos-servico-' . $id, _('Atendimentos por serviço'));
                    $chart->setType('pie');
                    $data = array();
                    foreach ($atendimentos as $k => $v) {
                        $data[] = array($k, (int) $v);
                    }
                    $chart->addSerie(new Serie('Atendimentos', $data));
                    $script .= '<div id="' . $chart->getId() .'" class="chart pie atendimentos servico"></div>';
                    $script .= $chart->toString();
                }
                ?>
                <div class="unidade">
                    <div class="wrap">
                        <h3 class="title"><?php SGA::out($unidade->getNome()) ?></h3>
                        <?php echo $script ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div id="tab-graficos">
            
        </div>
        <div id="tab-relatorios">
            
        </div>
    </div>
    <script type="text/javascript"> $('#tabs').tabs(); </script>
</div>