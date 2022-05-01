<?php /* @var $this CI_Loader */ ?>

<div class="contentphone cf">
    <div class="selectbox" name="country">
        <span class="selectchoice"></span>
        <ul>
            <li rel-placeholder="100 000 00 000" value="+49" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '49' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/allemagne.png" alt="Allemagne">Allemagne
            </li>
            <li rel-placeholder="00 000 00 00" value="+27" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '27' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/arique-du-sud.png" alt="Afrique du sud">Afrique du sud
            </li>
            <li rel-placeholder="000 000 000" value="+61" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '61' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/australie.png" alt="Australie">Australie
            </li>
            <li rel-placeholder="0 000 000" value="+43" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '43' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/autriche.png" alt="Autriche">Autriche
            </li>
            <li rel-placeholder="000 00 00 00" value="+32" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '32' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/belgique.png" alt="Belgique">Belgique
            </li>
            <li rel-placeholder="000 000-000" value="+1" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '1' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/canada.png" alt="Canada">Canada
            </li>
            <li rel-placeholder="100.00.00.00.00" value="+86" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '86' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/chine.png" alt="Chine">Chine
            </li>
            <li rel-placeholder="00 00 00 00" value="+45" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '45' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/danemark.png" alt="Danemark">Danemark
            </li>
            <li rel-placeholder="600 000 000" value="+34" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '34' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/espagne.png" alt="Espagne">Espagne
            </li>
            <li rel-placeholder="(000) 000-0000" value="+1" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '1' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/etats-unis.png" alt="Etats-Unis">Etats-Unis
            </li>
            <li rel-placeholder="6 00 00 00 00" value="+33" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '33' || $this->getController()->getBusinessUser()->getPrefixeTelephone() == '' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/france.png" alt="France">France
            </li>
            <li rel-placeholder="00 00 00 00" value="+852" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '852' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/hong-kong.png" alt="Allemagne">Hong-kong
            </li>
            <li rel-placeholder="(00) 00 00 00 00" value="+91" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '91' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/inde.png" alt="Inde">Inde
            </li>
            <li rel-placeholder="300 000 0000" value="+39" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '39' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/italie.png" alt="Italie">Italie
            </li>
            <li rel-placeholder="0 0000 0000" value="+81" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '81' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/japon.png" alt="Japon">Japon
            </li>
            <li rel-placeholder="0 00 00 00 00" value="+262" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '262' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/france.png" alt="La Reunion">La Réunion
            </li>
            <li rel-placeholder="0 00 00 00 00" value="+596" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '596' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/france.png" alt="Martinique">Martinique
            </li>
            <li rel-placeholder="000 00 00 00" value="+590" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '590' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/france.png" alt="La Reunion">Guadeloupe
            </li>
            <li rel-placeholder="601 000 000" value="+352" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '352' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/luxembourg.png" alt="Luxembourg">Luxembourg
            </li>
            <li rel-placeholder="00 000 00 00" value="+31" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '31' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/pays-bas.png" alt="Pays-Bas">Pays-Bas
            </li>
            <li rel-placeholder="00 000 00 00" value="+48" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '48' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/pologne.png" alt="Pologne">Pologne
            </li>
            <li rel-placeholder="000 000 000" value="+351" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '351' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/portugal.png" alt="Portugal">Portugal
            </li>
            <li rel-placeholder="" value="+44" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '44' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/royaume-uni.png" alt="Royaume-Uni">Royaume-Uni
            </li>
            <li rel-placeholder="00 000 00 00" value="+41" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '41' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/swisse.png" alt="Suisse">Suisse
            </li>
            <li rel-placeholder="00 00 00 00" value="+65" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '65' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/Singapore.png" alt="Singapour">Singapour
            </li>
            <li rel-placeholder="00 000 000" value="+216" class="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() == '216' ? 'selected' : ''; ?>">
                <img src="/assets/img/icons/drapeaux/Tunisia.png" alt="Tunisie">Tunisie
            </li>
        </ul>
    </div>
    <input class="selectinputphoneext" type="tel" name="exttelephone" value="<?php echo $this->getController()->getBusinessUser()->getPrefixeTelephone() != '' ? '+' . $this->getController()->getBusinessUser()->getPrefixeTelephone() : '+33'; ?>" placeholder="+33" disabled/>
    <input class="selectinputphone" type="tel" name="telephone" value="<?php echo strlen(trim($this->getController()->getBusinessUser()->getTelephone())) > 5 ? trim($this->getController()->getBusinessUser()->getTelephone()) : ''; ?>" placeholder="6 00 00 00 00"/>
</div>
<a href="#" class="bg_blue custombutton btninprocess" onclick="verification_telephone(); return false;">Vérifier mon numéro</a>