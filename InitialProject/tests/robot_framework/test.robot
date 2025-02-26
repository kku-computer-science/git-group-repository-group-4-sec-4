*** Settings ***
Library    SeleniumLibrary

*** Variables ***
${URL}     http://127.0.0.1:8000/
${CHROME_DRIVER_PATH}    /Users/ptpspp/Documents/GitHub/git-group-repository-group-4-sec-4/InitialProject/tests/robot_framework/chromedriver-mac-arm64/chromedriver

*** Test Cases ***
Open Web Page
    [Documentation]    เปิดเว็บและตรวจสอบการเปลี่ยนภาษา
    Open Browser    ${URL}    chrome    executable_path=${CHROME_DRIVER_PATH}
    Title Should Be    ระบบข้อมูลงานวิจัย วิทยาลัยการคอมพิวเตอร์
    
    # คลิกปุ่มเปลี่ยนภาษา
    Click Element    id=navbarDropdownMenuLink

    # เลือกตัวเลือกภาษาแรกใน dropdown โดยใช้ id
    Click Element    id=language-th  # แทนที่ด้วย id ของตัวเลือกภาษาแรกที่ต้องการ
    Sleep    2  # รอให้เว็บโหลดภาษาใหม่

    # ตรวจสอบว่าข้อความเปลี่ยนไปถูกต้อง
    ${translated_text}=    Get Text    id=navbarDropdownMenuLink
    ${expected_text}=    Set Variable    ไทย  # ข้อความที่ควรเป็นหลังจากเปลี่ยนภาษา

    Should Be Equal    ${translated_text}    ${expected_text}    Test Failed! Expected '${expected_text}', but got '${translated_text}'

    Log    Test Passed! Language translation works correctly.
    Close Browser
