    *** Settings ***
Documentation    Test suite for verifying translation on the home page including Banner image.
Library          SeleniumLibrary
Library          String
Test Teardown    Close Browser

*** Variables ***
${BROWSER}    chrome
${URL}        http://cs0404.cpkkuhost.com/
${WAIT_TIME}  3s

@{EXPECTED_THAI_TEXTS}     
    ...    ระบบการจัดการเอกสารการวิจัย    
    ...    วิทยาลัยการคอมพิวเตอร์ มหาวิทยาลัยขอนแก่น    
    ...    วิทยาลัยชั้นนำเพื่อผลิตบัณฑิต วิจัย และบริการวิชาการ    
    ...    รายงานจำนวนบทความทั้งหมด (5 ปี : สะสม)    
    ...    ปี    
    ...    จำนวนบทความ    
    ...    ก่อนปี

@{EXPECTED_ENGLISH_TEXTS}     
    ...    Research Document Management System    
    ...    College of Computing, Khon Kaen University    
    ...    A leading college for producing graduates, research, and academic services    
    ...    Report the total number of articles (5 years : cumulative)    
    ...    Year    
    ...    Number of Articles    
    ...    Before Year

@{EXPECTED_CHINESE_TEXTS}     
    ...    研究文档管理系统    
    ...    计算机学院，孔敬大学    
    ...    领先的学院，培养毕业生、研究和学术服务    
    ...    报告总文章数 (5年累计)    
    ...    年    
    ...    文章数量    
    ...    一年前

${LANG_TO_THAI}         xpath=//a[contains(@class, 'dropdown-item') and contains(text(), 'ไทย')]
${LANG_TO_ENGLISH}      xpath=//a[contains(@class, 'dropdown-item') and contains(text(), 'English')]
${LANG_TO_CHINESE}      xpath=//a[contains(@class, 'dropdown-item') and contains(text(), '中文')]

*** Keywords ***
Open Browser To Home Page
    Open Browser    ${URL}    ${BROWSER}
    Maximize Browser Window
    Wait Until Page Contains Element    ${LANG_TO_THAI}    timeout=10s

Wait And Click
    [Arguments]    ${locator}
    Wait Until Element Is Visible    ${locator}    timeout=10s
    Click Element    ${locator}

Verify Page Contains Texts
    [Arguments]    @{expected_texts}
    ${html_source}=    Get Source
    Log    HTML Source: ${html_source}
    FOR    ${text}    IN    @{expected_texts}
        Should Contain    ${html_source}    ${text}
    END

Verify Banner For Language
    [Arguments]    ${lang_code}
    ${banner_src}=    Get Element Attribute    xpath=//div[@class="carousel-inner"]/div[1]/img    src
    Log    Banner src is: ${banner_src}
    Should Contain    ${banner_src}    /img/${lang_code}/Banner

*** Test Cases ***
Thai To English
    [Documentation]    Starting from default Thai, switch to English and verify texts and banner.
    Open Browser To Home Page
    Sleep    ${WAIT_TIME}
    Verify Page Contains Texts    @{EXPECTED_THAI_TEXTS}
    Verify Banner For Language    th
    Wait And Click    ${LANG_TO_ENGLISH}
    Sleep    ${WAIT_TIME}
    Verify Page Contains Texts    @{EXPECTED_ENGLISH_TEXTS}
    Verify Banner For Language    en

Thai To Chinese
    [Documentation]    Starting from default Thai, switch to Chinese and verify texts and banner.
    Open Browser To Home Page
    Sleep    ${WAIT_TIME}
    Verify Page Contains Texts    @{EXPECTED_THAI_TEXTS}
    Verify Banner For Language    th
    Wait And Click    ${LANG_TO_CHINESE}
    Sleep    ${WAIT_TIME}
    Verify Page Contains Texts    @{EXPECTED_CHINESE_TEXTS}
    Verify Banner For Language    cn

English To Chinese
    [Documentation]    Switch from Thai to English then to Chinese, verify texts and banner.
    Open Browser To Home Page
    Sleep    ${WAIT_TIME}
    Verify Page Contains Texts    @{EXPECTED_THAI_TEXTS}
    Verify Banner For Language    th
    Wait And Click    ${LANG_TO_ENGLISH}
    Sleep    ${WAIT_TIME}
    Verify Page Contains Texts    @{EXPECTED_ENGLISH_TEXTS}
    Verify Banner For Language    en
    Wait And Click    ${LANG_TO_CHINESE}
    Sleep    ${WAIT_TIME}
    Verify Page Contains Texts    @{EXPECTED_CHINESE_TEXTS}
    Verify Banner For Language    cn

Chinese To Thai
    [Documentation]    Switch from Thai to Chinese then back to Thai, verify texts and banner.
    Open Browser To Home Page
    Sleep    ${WAIT_TIME}
    Verify Page Contains Texts    @{EXPECTED_THAI_TEXTS}
    Verify Banner For Language    th
    Wait And Click    ${LANG_TO_CHINESE}
    Sleep    ${WAIT_TIME}
    Verify Page Contains Texts    @{EXPECTED_CHINESE_TEXTS}
    Verify Banner For Language    cn
    Wait And Click    ${LANG_TO_THAI}
    Sleep    ${WAIT_TIME}
    Verify Page Contains Texts    @{EXPECTED_THAI_TEXTS}
    Verify Banner For Language    th
