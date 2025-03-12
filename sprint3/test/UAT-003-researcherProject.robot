*** Settings ***   
Library          SeleniumLibrary
Test Teardown    Close Browser

*** Variables ***
${BROWSER}           chrome
${HOME_URL}          https://cs0404.cpkkuhost.com/researchproject
${WAIT_TIME}         3s
${WEBDRIVER_PATH}    /Users/ptpspp/Documents/GitHub/git-group-repository-group-4-sec-4/sprint3/test/chromedriver-mac-arm64/chromedriver

# เปลี่ยนภาษา (ตัวเลือกใน dropdown)
${LANG_DROPDOWN_TOGGLE}    xpath=//a[@id="navbarDropdownMenuLink"]
${LANG_TO_THAI}       xpath=//div[contains(@class, 'dropdown-menu')]//a[contains(@href, '/lang/th')]
${LANG_TO_CHINESE}    xpath=//div[contains(@class, 'dropdown-menu')]//a[contains(@href, '/lang/zh')]

# ตรวจสอบข้อความที่ต้องปรากฏหลังจากเปลี่ยนภาษา
@{TEXT_TH}    
...    โครงการบริการวิชาการ/ โครงการวิจัย
...    ระยะเวลาของโครงการ 1 สิงหาคม 2020 ถึง 19 สิงหาคม 2020
...    ประเภทเงินทุน ทุนภายนอก
...    หน่วยงานสนับสนุน สำนักงานปลัดกระทรวงอุดมศึกษา วิทยาศาสตร์ วิจัยและนวัตกรรม
...    งบประมาณที่จัดสรร 90,000 บาท
...    อ. ธนพล ตั้งชูพงศ์

@{TEXT_ENG}    
...    Academic service projects/research projects
...    Project Duration 1 August 2020 to 19 August 2020
...    Funding Type External S
...    Responsible Department Computer Science
...    Budget Allocated 90,000 THB
...    Lecturer Thanaphon Tangchoopong

@{TEXT_ZH}    
...    学术服务项目/研究项目
...    项目期限 1 八月 2020 至 19 八月 2020
...    资金类型 外部奖学金
...    资助机构 高等教育、科学、研究和创新部常务秘书办公室
...    负责部门 计算机科学
...    预算分配 90,000 泰铢
...    讲师 塔纳蓬 唐楚朋

*** Keywords ***
Open Browser To Home Page
    Open Browser    ${HOME_URL}    ${BROWSER}    executable_path=${WEBDRIVER_PATH}
    Maximize Browser Window

  

Change Language To Thai
    Click Element    ${LANG_DROPDOWN_TOGGLE}
    Sleep    2s
    Wait Until Element Is Enabled    ${LANG_TO_THAI}    timeout=10s
    Click Element    ${LANG_TO_THAI}
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{TEXT_TH}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to Thai successfully."    INFO
    Log To Console  "Language changed to Thai successfully."  # แสดงผลบน Console


Change Language To English
    Click Element    ${LANG_DROPDOWN_TOGGLE}
    Sleep    2s
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{TEXT_ENG}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to English successfully."

Change Language To Chinese
    Click Element    ${LANG_DROPDOWN_TOGGLE}
    Sleep    2s
    Wait Until Element Is Enabled    ${LANG_TO_CHINESE}    timeout=10s
    Click Element    ${LANG_TO_CHINESE}
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{TEXT_ZH}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to Chinese successfully."

*** Test Cases ***
Admin Login And Change Language To Thai
    Open Browser To Home Page
    Change Language To Thai
    Close Browser

Admin Login And Change Language To English
    Open Browser To Home Page
    Change Language To English
    Close Browser

Admin Login And Change Language To Chinese
    Open Browser To Home Page
    Change Language To Chinese
    Close Browser
